// stores/historyStore.js
import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useHistoryStore = defineStore("history", {
  state: () => ({
    action_history: [],
    loading: false,
  }),

  actions: {
    async fetchAll() {
      this.loading = true;
      try {
        const res = await axiosClient.get("/api/action_history");
        this.action_history = res.data;
      } catch (err) {
        console.error("Error fetching Action History data:", err);
      } finally {
        this.loading = false;
      }
    },
  },
});
