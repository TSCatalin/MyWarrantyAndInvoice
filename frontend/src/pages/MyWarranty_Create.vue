<script setup>
import { ref } from "vue";
import axiosClient from "../axios";
import router from "../router";

const data = ref({
  warranty_id: "",
  invoice_number: "",
  product_name: "",
  seller: "",
  customer_name: "",
  date_purchase: "",
  warranty_end_date: "",
  warranty_file: null,
});

const errors = ref({
  warranty_id: [],
  invoice_number: [],
  product_name: [],
  seller: [],
  customer_name: [],
  date_purchase: [],
  warranty_end_date: [],
  warranty_file: [],
});

function submit() {
  const formData = new FormData();
  formData.append("warranty_id", data.value.warranty_id);
  formData.append("invoice_number", data.value.invoice_number);
  formData.append("product_name", data.value.product_name);
  formData.append("seller", data.value.seller);
  formData.append("customer_name", data.value.customer_name);
  formData.append("date_purchase", data.value.date_purchase);
  formData.append("warranty_end_date", data.value.warranty_end_date);

  if (data.value.warranty_file) {
    formData.append("warranty_file", data.value.warranty_file);
  } else {
    console.log("No file was selected.");
  }

  axiosClient
    .post("api/warranty", formData)
    .then((response) => {
      router.push({ name: "MyWarranty" });
    })
    .catch((error) => {
      if (error.response) {
        errors.value = error.response.data.errors;
      } else {
        console.log("Error without response:", error);
      }
    });
}

function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
}

const invoiceNumber = ref("");
const isCheckboxChecked = ref(false);

const valueInvoiceNumber = ref();

const getInvoiceNumber = () => {
  axiosClient
    .get("/api/invoice/get-invoice-numbers")
    .then((response) => {
      valueInvoiceNumber.value = response.data.data;
    })
    .catch((error) => {
      console.error("Error fetching getInvoiceNumber data:", error);
    });
};

const handleCheckboxChange = () => {
  if (isCheckboxChecked.value) {
    getInvoiceNumber();
  }
};
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        Add Warranty
      </h1>
    </div>
  </header>
  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <form
        @submit.prevent="submit"
        class="space-y-4 max-w-lg mx-auto bg-white p-10 rounded-lg border-2 border-white hover:border-yellow-300"
      >
        <div class="mb-5">
          <label
            for="text"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 48 48"
              class="mr-2"
            >
              <g
                fill="none"
                stroke="currentColor"
                stroke-linejoin="round"
                stroke-width="4"
              >
                <rect width="36" height="36" x="6" y="6" rx="3" />
                <path stroke-linecap="round" d="M6 17h36M17 42V17" />
              </g></svg
            >Warranty ID</label
          >
          <input
            type="text"
            id="text"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            placeholder="ABCDE12345"
            v-model="data.warranty_id"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.warranty_id ? errors.warranty_id[0] : "" }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="invoice_number"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 3h14v18l-1.032-.884a2 2 0 0 0-2.603 0L14.333 21l-1.031-.884a2 2 0 0 0-2.604 0L9.667 21l-1.032-.884a2 2 0 0 0-2.603 0L5 21zm10 4H9m6 4H9m6 4h-4"
              /></svg
            >Invoice number</label
          >
          <input
            v-if="!isCheckboxChecked"
            type="text"
            id="invoice_number"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            placeholder="ABC-123-334"
            v-model="data.invoice_number"
          />

          <select
            v-if="isCheckboxChecked"
            v-model="data.invoice_number"
            id="checkBoxInvoice"
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-200 bg-white text-black"
          >
            <option value="" class="text-gray-300">Select Seller</option>
            <option
              v-for="val in valueInvoiceNumber"
              :key="val"
              :value="val"
              class="text-neutral-400 bg-white hover:bg-yellow-200 hover:text-black"
            >
              {{ val }}
            </option>
          </select>

          <div class="flex items-center mt-1">
            <input
              type="checkbox"
              id="getInvoiceNumberCheckbox"
              v-model="isCheckboxChecked"
              class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all duration-200 ease-in-out"
              @change="handleCheckboxChange"
            />
            <label
              for="getInvoiceNumberCheckbox"
              class="ml-2 text-sm text-gray-700"
            >
              Have you already registered an invoice?
            </label>
          </div>

          <p class="text-sm text-red-600">
            {{
              errors && errors.invoice_number ? errors.invoice_number[0] : ""
            }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="product_name"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 2048 2048"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="m960 120l832 416v1040l-832 415l-832-415V536zm625 456L960 264L719 384l621 314zM960 888l238-118l-622-314l-241 120zM256 680v816l640 320v-816zm768 1136l640-320V680l-640 320z"
              /></svg
            >Product Name</label
          >
          <input
            type="text"
            id="product_name"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            placeholder="Abcdef Abcdef"
            v-model="data.product_name"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.product_name ? errors.product_name[0] : "" }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="seller"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M4 6V4h16v2zm0 14v-6H3v-2l1-5h16l1 5v2h-1v6h-2v-6h-4v6zm2-2h6v-4H6zm-.95-6h13.9zm0 0h13.9l-.6-3H5.65z"
              /></svg
            >Seller</label
          >
          <input
            type="text"
            id="seller"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            placeholder="Abcdef"
            v-model="data.seller"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.seller ? errors.seller[0] : "" }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="customer_name"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 32 32"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M29.755 21.345A1 1 0 0 0 29 21h-2v-2c0-1.102-.897-2-2-2h-4c-1.103 0-2 .898-2 2v2h-2a1 1 0 0 0-.99 1.142l1 7A1 1 0 0 0 18 30h10a1 1 0 0 0 .99-.858l1-7a1 1 0 0 0-.235-.797M21 19h4v2h-4zm6.133 9h-8.266l-.714-5h9.694zM10 20h2v10h-2z"
              />
              <path
                fill="currentColor"
                d="m16.78 17.875l-1.906-2.384l-1.442-3.605A2.99 2.99 0 0 0 10.646 10H5c-1.654 0-3 1.346-3 3v7c0 1.103.897 2 2 2h1v8h2V20H4v-7a1 1 0 0 1 1-1h5.646c.411 0 .776.247.928.629l1.645 3.996l2 2.5zM4 5c0-2.206 1.794-4 4-4s4 1.794 4 4s-1.794 4-4 4s-4-1.794-4-4m2 0c0 1.103.897 2 2 2s2-.897 2-2s-.897-2-2-2s-2 .897-2 2"
              /></svg
            >Customer Name</label
          >
          <input
            type="text"
            id="customer_name"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            placeholder="Popescu Ion"
            v-model="data.customer_name"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.customer_name ? errors.customer_name[0] : "" }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="date_purchase"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 16 16"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M14.5 16h-13C.67 16 0 15.33 0 14.5v-12C0 1.67.67 1 1.5 1h13c.83 0 1.5.67 1.5 1.5v12c0 .83-.67 1.5-1.5 1.5M1.5 2c-.28 0-.5.22-.5.5v12c0 .28.22.5.5.5h13c.28 0 .5-.22.5-.5v-12c0-.28-.22-.5-.5-.5z"
              />
              <path
                fill="currentColor"
                d="M4.5 4c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m7 0c-.28 0-.5-.22-.5-.5v-3c0-.28.22-.5.5-.5s.5.22.5.5v3c0 .28-.22.5-.5.5m4 2H.5C.22 6 0 5.78 0 5.5S.22 5 .5 5h15c.28 0 .5.22.5.5s-.22.5-.5.5"
              /></svg
            >Date Purchase</label
          >
          <input
            type="date"
            id="date_purchase"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            v-model="data.date_purchase"
            :max="formatDate(new Date())"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.date_purchase ? errors.date_purchase[0] : "" }}
          </p>
        </div>

        <div class="mb-5">
          <label
            for="date_warranty_end"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
            ><svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M21 17h3l-4 4l-4-4h3V3h2zM8 16h3v-3H8zm5-11h-1V3h-2v2H6V3H4v2H3c-1.11 0-2 .89-2 2v11c0 1.11.89 2 2 2h10c1.11 0 2-.89 2-2V7c0-1.11-.89-2-2-2M3 18v-7h10v7z"
              /></svg
            >Warranty End Date</label
          >
          <input
            type="date"
            id="date_warranty_end"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
            v-model="data.warranty_end_date"
            :disabled="!data.date_purchase"
            :min="data.date_purchase"
          />
          <p class="text-sm text-red-600">
            {{
              errors && errors.warranty_end_date
                ? errors.warranty_end_date[0]
                : ""
            }}
          </p>
        </div>

        <div class="mb-6">
          <label
            for="file_input"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13.324 8.436L9.495 12.19c-.364.36-.564.852-.556 1.369a2 2 0 0 0 .6 1.387c.375.371.88.584 1.403.593a1.92 1.92 0 0 0 1.386-.55l3.828-3.754a3.75 3.75 0 0 0 1.112-2.738a4 4 0 0 0-1.198-2.775a4.1 4.1 0 0 0-2.808-1.185a3.85 3.85 0 0 0-2.77 1.098L6.661 9.39a5.63 5.63 0 0 0-1.667 4.107a6 6 0 0 0 1.798 4.161a6.15 6.15 0 0 0 4.21 1.778a5.77 5.77 0 0 0 4.157-1.646l3.829-3.756"
              /></svg
            >Warranty File
          </label>

          <div class="relative">
            <input
              id="file_input"
              type="file"
              class="block w-full text-sm p-2 text-gray-900 border border-gray-300 hover:border-yellow-300 hover:border-2 rounded-lg cursor-pointer bg-white transition-colors duration-300 ease-in-out"
              @change="data.warranty_file = $event.target.files[0]"
              accept=".pdf,.docx,.jpg,.jpeg,.png"
            />
          </div>

          <p class="text-xs text-gray-500 mt-1">
            Accepted formats: PDF, DOCX, JPG, JPEG, PNG
          </p>

          <p class="text-sm text-red-600 mt-1">
            {{ errors && errors.warranty_file ? errors.warranty_file[0] : "" }}
          </p>
        </div>

        <button
          type="submit"
          class="text-gray-900 border-2 cursor-pointer border-yellow-300 bg-yellow-300 hover:bg-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="24px"
            viewBox="0 -960 960 960"
            width="24px"
            fill="#000000"
            class="mr-2"
          >
            <path
              d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
            />
          </svg>
          Add new Warranty
        </button>
      </form>
    </div>
  </main>
</template>

<style scoped></style>
