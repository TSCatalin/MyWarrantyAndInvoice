import { defineStore } from "pinia";
import axiosClient from "../axios";

const useUserStore = defineStore("user", {
  state: () => ({
    user: null,
    errors: {},
  }),
  actions: {
    async fetchUser() {
      try {
        const { data } = await axiosClient.get("/api/user");
        this.user = data;
        return {
          success: true,
          verified: !!data.email_verified_at,
        };
      } catch (error) {
        this.user = null;
        console.log("User is not authenticated.", error);
        return { success: false };
      }
    },
    async logoutUser() {
      try {
        await axiosClient.post("/logout");
        this.user = null;
        return { success: true };
      } catch (error) {
        console.error("Logout error:", error);
      }
    },

    async updateProfile(data) {
      const formData = new FormData();
      formData.append("name", data.name);
      formData.append("email", data.email);
      formData.append("_method", "PUT");

      try {
        await axiosClient.post("profile", formData);
        this.errors = {};
        this.user = { ...this.user, name: data.name };
        return { success: true };
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
          return { success: false, errors: this.errors };
        } else {
          return { success: false, errors: { general: "Unknown error:" } };
        }
      }
    },

    async updatePassword(data) {
      const formData = new FormData();
      formData.append("current_password", data.current_password);
      formData.append("password", data.password);
      formData.append("password_confirmation", data.password_confirmation);
      formData.append("_method", "PUT");

      try {
        await axiosClient.post("password", formData);
        this.errors = {};
        return { success: true };
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
          return { success: false, errors: this.errors };
        } else {
          return { success: false, errors: { general: "Unknown error:" } };
        }
      }
    },

    async deleteAccount(password) {
      if (!confirm("Are you sure you want to delete your account?")) return;

      const formData = new FormData();
      formData.append("password", password);

      try {
        const response = await axiosClient.post("profile", formData);
        if (response.data.redirect_to_login) {
          this.user = null;
        } else {
          alert(response.data.message);
        }
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors;
          return { success: false, errors: this.errors };
        } else {
          return { success: false, errors: { general: "Unknown error:" } };
        }
      }
    },
  },
});

export default useUserStore;
