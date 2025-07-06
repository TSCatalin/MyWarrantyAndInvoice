import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useAuthStore = defineStore("authUser", {
  state: () => ({}),

  actions: {
    async loginUser(data) {
      try {
        await axiosClient.get("/sanctum/csrf-cookie");
        await axiosClient.post("/login", data);
        const response = await axiosClient.get(
          "/api/warranty/updateStatusWarranty"
        );
        this.errorMessage = null;
        return { success: true };
      } catch (error) {
        let message = "Unknown error.";
        if (error.response?.data?.message) {
          message = error.response.data.message;
        }

        this.errorMessage = message;

        return { success: false, message };
      }
    },

    async registerUser(data) {
      try {
        await axiosClient.get("/sanctum/csrf-cookie");
        await axiosClient.post("/register", data);

        return { success: true };
      } catch (error) {
        if (error.response?.data?.errors) {
          return {
            success: false,
            errors: error.response.data.errors,
          };
        }

        return {
          success: false,
          errors: { general: "Unknown error occurred." },
        };
      }
    },

    async resendVerificationEmail() {
      if (this.countdown > 0) return;

      try {
        await axiosClient.post("/email/verification-notification");
        this.message = "Verification email has been resent.";
      } catch {
        this.message = "An error occurred while resending the email.";
      }

      this.countdown = 60;
      if (this.countdownInterval) {
        clearInterval(this.countdownInterval);
      }

      this.countdownInterval = setInterval(() => {
        this.countdown--;
        if (this.countdown <= 0) {
          clearInterval(this.countdownInterval);
          this.message = "";
          this.countdownInterval = null;
        }
      }, 1000);
    },

    async forgotPassword(data) {
      try {
        await axiosClient.post("forgot-password", {
          email: data.email,
        });
        this.errorMessage = null;
        let message = "We have emailed your password reset link.";
        return { success: true, message };
      } catch (error) {
        let message = "Unknown error.";
        if (error.response?.data?.message) {
          message = error.response.data.message;
        }

        this.errorMessage = message;

        return { success: false, message };
      }
    },

    async resetPassword(data) {
      const formData = new FormData();
      formData.append("token", data.token);
      formData.append("email", data.email);
      formData.append("password", data.password);
      formData.append("password_confirmation", data.password_confirmation);

      try {
        await axiosClient.post("reset-password", formData);
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
    async contactForm(data) {
      try {
        await axiosClient.get("/sanctum/csrf-cookie");
        await axiosClient.post("/api/contact", data);
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
  },
});
