import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useWarrantyStore = defineStore("warranties", {
  state: () => ({
    warranty: null,
    sellers: [],
    status: null,
    warranties: [],
    warrantiesCount: 0,
    warrantiesMonth: 0,
    warrantiesAvailable: 0,
    warrantiesUnavailable: 0,
    pagination: {
      current_page: 1,
      last_page: 1,
    },
    loading: false,
    loadingWarranties: false,
  }),

  actions: {
    async fetchAll(filters, page = 1) {
      this.loading = true;
      this.loadingWarranties = true;

      const params = {
        seller: filters.seller,
        status: filters.status,
        product_name: filters.product_name,
        sortBy: filters.sortBy,
        page: page,
      };

      try {
        const response = await axiosClient.get("/api/warranty", { params });
        this.warranty = response.data;
        this.sellers = response.data.seller;
        this.status = response.data.status;
        this.pagination.current_page = response.data.meta.current_page;
        this.pagination.last_page = response.data.meta.last_page;

        if (response.data.data.length === 0) {
          this.loadingWarranties = false;
        } else {
          this.loadingWarranties = true;
        }
      } catch (error) {
        console.error("Error fetching warranty data:", error);
      } finally {
        this.loading = false;
      }
    },

    async deleteWarranty(id) {
      if (!confirm("Are you sure you want to delete this Warranty?"))
        return false;

      try {
        await axiosClient.delete(`/api/warranty/${id}`);
        await this.fetchAll(
          {
            seller: "",
            status: "",
            product_name: "",
            sortBy: "",
          },
          this.pagination.current_page
        );
        return true;
      } catch (error) {
        console.error("Error deleting warranty:", error);
        return false;
      }
    },

    async fetchWarranty(warrantyId) {
      try {
        const response = await axiosClient.get(`/api/warranty/${warrantyId}`);
        this.warranty = response.data.data;
        return { success: true };
      } catch (error) {
        console.error("Error retrieving warranty:", error.response || error);
        if (error.response && error.response.status === 404) {
          return { notFound: true };
        }

        if (error.response && error.response.status === 500) {
          return { serverError: true, data: error.response.data };
        }

        return { error: true };
      }
    },
    async updateWarranty(warrantyId, data) {
      const formData = new FormData();
      formData.append("warranty_id", data.warranty_id);
      formData.append("invoice_number", data.invoice_number);
      formData.append("product_name", data.product_name);
      formData.append("seller", data.seller);
      formData.append("customer_name", data.customer_name);
      formData.append("date_purchase", data.date_purchase);
      formData.append("warranty_end_date", data.warranty_end_date);

      if (data.warranty_file) {
        formData.append("warranty_file", data.warranty_file);
      } else {
        console.log("No file was selected.");
      }

      formData.append("_method", "PUT");

      try {
        const response = await axiosClient.post(
          `/api/warranty/${warrantyId}`,
          formData
        );
        this.errors = {};
        this.invoice = response.data.data;
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

    async createWarranty(data) {
      const formData = new FormData();
      formData.append("warranty_id", data.warranty_id);
      formData.append("invoice_number", data.invoice_number);
      formData.append("product_name", data.product_name);
      formData.append("seller", data.seller);
      formData.append("customer_name", data.customer_name);
      formData.append("date_purchase", data.date_purchase);
      formData.append("warranty_end_date", data.warranty_end_date);

      if (data.warranty_file) {
        formData.append("warranty_file", data.warranty_file);
      }

      try {
        await axiosClient.post("/api/warranty", formData);
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

    async fetchDashboardWarranties() {
      try {
        const response = await axiosClient.get(
          "/api/warranty/dashboardWarranty"
        );

        this.warranties = response.data.warranties;
        this.warrantiesCount = response.data.warranties_count;
        this.warrantiesMonth = response.data.warrantiesCountLastMonth;
        this.warrantiesAvailable = response.data.warranties_count_status_1;
        this.warrantiesUnavailable = response.data.warranties_count_status_0;

        this.loadingWarranties = this.warranties.length > 0;

        return { success: true };
      } catch (error) {
        console.error(
          "Error retrieving dashboard warranties:",
          error.response || error
        );
      }
    },
  },
});
