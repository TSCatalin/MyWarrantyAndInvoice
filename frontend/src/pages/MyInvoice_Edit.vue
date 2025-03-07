<script setup>
import axiosClient from "../axios";
import router from "../router";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const invoiceId = route.params.id;
const loading = ref(true);

const data = ref({
  invoice_number: "",
  products_name: "",
  seller: "",
  value: "",
  currency: "",
  customer_name: "",
  date_purchase: "",
  invoice_file: null,
});

const errors = ref({
  invoice_number: [],
  products_name: [],
  seller: [],
  value: [],
  currency: [],
  customer_name: [],
  date_purchase: [],
  invoice_file: [],
});

function submit() {
  let formData = new FormData();
  if (typeof data.value.value === 'string' && data.value.value.includes(",")) {
    data.value.value = data.value.value.replace(",", ".");
  }
  formData.append("invoice_number", data.value.invoice_number);
  formData.append("products_name", data.value.products_name);
  formData.append("seller", data.value.seller);
  formData.append("value", data.value.value);
  formData.append("currency", data.value.currency);
  formData.append("customer_name", data.value.customer_name);
  formData.append("date_purchase", data.value.date_purchase);

  if (data.value.invoice_file) {
    formData.append("invoice_file", data.value.invoice_file);
  } else {
    console.log("Fișierul nu a fost selectat.");
  }
  formData.append('_method', 'PUT')

  axiosClient
    .post(`/api/invoice/${invoiceId}`, formData)
    .then((response) => {
      router.push({ name: "MyInvoice" });
    })
    .catch((error) => {
      if (error.response) {
        console.log(error.response);
        errors.value = error.response.data.errors;
      } else {
        console.log("Error without response:", error);
      }
    });
}

onMounted(() => {
  axiosClient
    .get(`/api/invoice/${invoiceId}`)
    .then((response) => {
      console.log(response.data);
      data.value = response.data.data;
      data.value.invoice_file = null;
      console.log(response.data.data.invoiceId);
      loading.value = false;
    })
    .catch((error) => {
      console.error("Eroare la preluarea garanției:", error.response);
      if (error.response && error.response.status === 500) {
        console.error("Server error:", error.response.data);
      }
      if (error.response && error.response.status === 404) {
        router.push("/not-found");
      }
      loading.value = false;
    });
});

function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        Invoice Edit
      </h1>
    </div>
  </header>
  <main>
    <div v-if="loading">Loading...</div>
    <div v-else class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <form @submit.prevent="submit" class="space-y-4 max-w-lg mx-auto">
      <div class="mb-5">
          <label
            for="invoice_number"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Invoice number</label
          >
          <input
            type="text"
            id="invoice_number"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="ABC-123-334"
            v-model="data.invoice_number"
          />
          <p class="text-sm text-red-600">
            {{
              errors && errors.invoice_number ? errors.invoice_number[0] : ""
            }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="products_name"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Products Name</label
          >
          <input
            type="text"
            id="products_name"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="Abcdef Abcdef"
            v-model="data.products_name"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.products_name ? errors.products_name[0] : "" }}
          </p>
        </div>
        <div class="mb-5">
          <label
            for="seller"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Seller</label
          >
          <input
            type="text"
            id="seller"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            placeholder="Abcdef"
            v-model="data.seller"
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.seller ? errors.seller[0] : "" }}
          </p>
        </div>

        <div class="mb-5 flex justify-between items-center">
          <div class="w-5/6 pr-2">
            <label
              for="value"
              class="block mb-2 text-sm font-medium text-gray-900"
              >Value</label
            >
            <input
              type="number"
              id="value"
              class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              placeholder="Abcdef"
              v-model="data.value"
              step="any"
            />
            <p class="text-sm text-red-600">
              {{ errors && errors.value ? errors.value[0] : "" }}
            </p>
          </div>

          <div class="w-1/6 pl-2">
            <label
              for="currency"
              class="block mb-2 text-sm font-medium text-gray-900"
              >Currency</label
            >
            <select
              id="currency"
              class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
              v-model="data.currency"
            >
              <option value="RON">RON</option>
              <option value="EUR">EUR</option>
              <option value="USD">USD</option>
              <option value="GBP">GBP</option>
            </select>
            <p class="text-sm text-red-600">
              {{ errors && errors.currency ? errors.currency[0] : "" }}
            </p>
          </div>
        </div>

        <div class="mb-5">
          <label
            for="customer_name"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Customer Name</label
          >
          <input
            type="text"
            id="customer_name"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
            class="block mb-2 text-sm font-medium text-gray-900"
            >Date Purchase</label
          >
          <input
            type="date"
            id="date_purchase"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
            v-model="data.date_purchase"
            :max="formatDate(new Date())" 
          />
          <p class="text-sm text-red-600">
            {{ errors && errors.date_purchase ? errors.date_purchase[0] : "" }}
          </p>
        </div>

        <div class="mb-5">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Invoice File</label
          >

          <input
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
            id="file_input"
            type="file"
            @change="data.invoice_file = $event.target.files[0]"
          />

          <p class="text-sm text-red-600">
            {{ errors && errors.invoice_file ? errors.invoice_file[0] : "" }}
          </p>
        </div>
        <button
          type="submit"
          class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2"
        >
         Edit Invoice
        </button>
      </form>
    </div>
  </main>
</template>

<style scoped></style>
