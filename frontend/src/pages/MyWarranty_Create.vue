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
    console.log("Fișierul nu a fost selectat.");
  }

  axiosClient
    .post("api/warranty", formData)
    .then((response) => {
      router.push({ name: "MyWarranty" });
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

function formatDate(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');  // Adăugăm 1 pentru lună și asigurăm formatul de 2 cifre
  const day = String(date.getDate()).padStart(2, '0');  // Asigurăm formatul de 2 cifre pentru zi
  return `${year}-${month}-${day}`;
}

</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        My Warranty
      </h1>
    </div>
  </header>
  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <form @submit.prevent="submit" class="space-y-4 max-w-lg mx-auto">
        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Warranty ID</label
          >
          <input
            type="text"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
            for="product_name"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Product Name</label
          >
          <input
            type="text"
            id="product_name"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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
          <label
            for="date_warranty_end"
            class="block mb-2 text-sm font-medium text-gray-900"
            >Warranty End Date</label
          >
          <input
            type="date"
            id="date_warranty_end"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
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

        <div class="mb-5">
          <label class="block mb-2 text-sm font-medium text-gray-900"
            >Warranty File</label
          >

          <input
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
            id="file_input"
            type="file"
            @change="data.warranty_file = $event.target.files[0]"
          />

          <p class="text-sm text-red-600">
            {{ errors && errors.warranty_file ? errors.warranty_file[0] : "" }}
          </p>
        </div>
        <button
          type="submit"
          class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2"
        >
          Add new Warranty
        </button>
      </form>
    </div>
  </main>
</template>

<style scoped></style>
