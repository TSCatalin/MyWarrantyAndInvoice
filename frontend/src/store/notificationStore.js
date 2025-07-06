import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useNotificationStore = defineStore("notifications", {
  state: () => ({
    notifications: [],
    notification: null,
    unreadCount: 0,
    loading: false,
  }),

  actions: {
    async fetchAll() {
      this.loading = true;
      try {
        try {
          const res = await axiosClient.get("/api/notifications");
          this.notifications = res.data;
        } catch (err) {
          console.error("Error fetching all notifications:", err);
        }
      } finally {
        this.loading = false;
      }
    },

    async fetchById(notificationId) {
      this.loading = true;
      try {
        const res = await axiosClient.get(
          `/api/notifications/${notificationId}`
        );
        const notificationData = res.data;
        this.notification = notificationData;
        return notificationData;
      } catch (err) {
        if (err.response?.status === 404) {
          throw new Error("NOT_FOUND");
        } else {
          console.error("Error fetching notification by ID:", err.response || err);
          throw err;
        }
      } finally {
        this.loading = false;
      }
    },

    async fetchUnreadCount() {
      try {
        const res = await axiosClient.get("/api/notifications/unread/count");
        this.unreadCount = res.data.unread_notifications_count ?? 0;
      } catch (err) {
        console.error("Error fetching unread count:", err);
      }
    },

    async markAsRead(notificationId) {
      try {
        const res = await axiosClient.post(
          `/api/notifications/${notificationId}/read`,
          notificationId
        );
        this.fetchUnreadCount();
        return res;
      } catch (err) {
        console.error("Error marking notification as read:", err);
        throw err;
      }
    },
  },
});
