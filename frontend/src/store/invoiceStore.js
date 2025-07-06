import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useInvoiceStore = defineStore("invoices", {
  state: () => ({
    invoices: [],
    invoice: null,
    invoiceNumbers: [],
    warranties: null,
    sellers: [],
    loading: false,
    loadingInvoice: false,
    invoicesCount: 0,
    invoicesMonth: 0,
    invoicesSum: null,
    pagination: {
      current_page: 1,
      last_page: 1,
    },
  }),

  actions: {
    async fetchAll(filters, page = 1) {
      this.loading = true;
      this.loadingInvoice = true;

      let params = {
        seller: filters.seller,
        status: filters.status,
        product_name: filters.product_name,
        sortBy: filters.sortBy,
        page: page,
      };

      try {
        const response = await axiosClient.get("/api/invoice", { params });
        this.invoice = response.data;
        this.sellers = response.data.seller;
        this.pagination.current_page = response.data.meta.current_page;
        this.pagination.last_page = response.data.meta.last_page;

        if (response.data.data.length === 0) {
          this.loadingInvoice = false;
        } else {
          this.loadingInvoice = true;
        }
      } catch (error) {
        console.error("Error fetching invoice data:", error);
      } finally {
        this.loading = false;
      }
    },
    async deleteInvoice(id) {
      if (!confirm("Are you sure you want to delete this Invoice?"))
        return false;

      try {
        await axiosClient.delete(`/api/invoice/${id}`);
        await this.fetchAll(
          {
            seller: "",
            product_name: "",
            sortBy: "",
          },
          this.pagination.current_page
        );
        return true;
      } catch (error) {
        console.error("Error deleting invoice:", error);
        return false;
      }
    },

    async fetchWarrantiesForInvoice(invoiceId) {
      let invoice;
      try {
        const invoiceResponse = await axiosClient.get(
          `/api/invoice/${invoiceId}`
        );
        invoice = invoiceResponse.data.data;
        this.invoice = invoice;
      } catch (error) {
        console.error("Error retrieving invoice:", error.response || error);
        return { error: { source: "invoice", ...error } };
      }

      try {
        const invoiceNumber = invoice.invoice_number;
        const warrantyResponse = await axiosClient.get(
          "/api/warranty/get-warrantyforinvoice",
          { params: { invoice_number: invoiceNumber } }
        );
        this.warranties = warrantyResponse.data;
        return { success: true };
      } catch (error) {
        console.error("Error retrieving warranty:", error.response || error);
        return { error: { source: "warranty", ...error } };
      }
    },

    async fetchInvoice(invoiceId) {
      try {
        const response = await axiosClient.get(`/api/invoice/${invoiceId}`);
        this.invoice = response.data.data;
        this.invoice.invoice_file = null;
        return { success: true };
      } catch (error) {
        console.error("Error retrieving invoice:", error.response || error);

        if (error.response && error.response.status === 404) {
          return { notFound: true };
        }

        if (error.response && error.response.status === 500) {
          return { serverError: true, data: error.response.data };
        }

        return { error: true };
      }
    },

    async updateInvoice(invoiceId, invoiceData) {
      const formData = new FormData();

      if (
        typeof invoiceData.value === "string" &&
        invoiceData.value.includes(",")
      ) {
        invoiceData.value = invoiceData.value.replace(",", ".");
      }

      formData.append("invoice_number", invoiceData.invoice_number);
      formData.append("products_name", invoiceData.products_name);
      formData.append("seller", invoiceData.seller);
      formData.append("value", invoiceData.value);
      formData.append("currency", invoiceData.currency);
      formData.append("customer_name", invoiceData.customer_name);
      formData.append("date_purchase", invoiceData.date_purchase);

      if (invoiceData.invoice_file) {
        formData.append("invoice_file", invoiceData.invoice_file);
      } else {
        console.log("The file was not selected.");
      }

      formData.append("_method", "PUT");

      try {
        const response = await axiosClient.post(
          `/api/invoice/${invoiceId}`,
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
          console.error("Unknown error:", error);
          return { success: false, errors: { general: "Unknown error:" } };
        }
      }
    },

    async createInvoice(invoiceData) {
      const formData = new FormData();

      if (
        typeof invoiceData.value === "string" &&
        invoiceData.value.includes(",")
      ) {
        invoiceData.value = invoiceData.value.replace(",", ".");
      }

      formData.append("invoice_number", invoiceData.invoice_number);
      formData.append("products_name", invoiceData.products_name);
      formData.append("seller", invoiceData.seller);
      formData.append("value", invoiceData.value);
      formData.append("currency", invoiceData.currency);
      formData.append("customer_name", invoiceData.customer_name);
      formData.append("date_purchase", invoiceData.date_purchase);

      if (invoiceData.invoice_file) {
        formData.append("invoice_file", invoiceData.invoice_file);
      }

      try {
        await axiosClient.post("/api/invoice", formData);
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

    async getInvoiceNumber() {
      try {
        const response = await axiosClient.get(
          "/api/invoice/get-invoice-numbers"
        );
        this.invoiceNumbers = response.data.data;
        return response.data.data;
      } catch (error) {
        console.error("Error fetching getInvoiceNumber data:", error);
        return null;
      }
    },

    async fetchDashboardInvoices() {
      try {
        const response = await axiosClient.get("/api/invoice/dashboardInvoice");

        this.invoices = response.data.invoices;
        this.invoicesCount = response.data.invoices_count;
        this.invoicesMonth = response.data.invoicesCountLastMonth;
        this.invoicesSum = response.data.sum_by_currency;

        this.loadingInvoice = this.invoices.length > 0;

        return { success: true };
      } catch (error) {
        console.error(
          "Error retrieving dashboard invoices:",
          error.response || error
        );
      }
    },
  },
});
