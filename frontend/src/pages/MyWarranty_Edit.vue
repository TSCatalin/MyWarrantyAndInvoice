<script setup>
import router from "../router";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import { useWarrantyStore } from "../store/warrantyStore";
import { useInvoiceStore } from "../store/invoiceStore";

const warrantyStore = useWarrantyStore();
const invoiceStore = useInvoiceStore();
const route = useRoute();
const warrantyId = route.params.id;
const loading = ref(true);
const isCheckboxChecked = ref(false);
const valueInvoiceNumber = ref();

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

async function submit() {
   errors.value = {};
  const result = await warrantyStore.updateWarranty(warrantyId, data.value);

  if (result.success) {
    router.push({ name: "MyWarranty" });
  } else {
    errors.value = result.errors;
  }
};


onMounted(async () => {
  const result = await warrantyStore.fetchWarranty(warrantyId);

  if (result.notFound) {
    router.push("/not-found");
  }

  if (result.serverError) {
    loading.value = false;
  }
  data.value = warrantyStore.warranty || {};
  data.value.warranty_file = null;
  loading.value = false;
});

onMounted(async () => {
  valueInvoiceNumber.value = null;
  const numbers = await invoiceStore.getInvoiceNumber();
  valueInvoiceNumber.value = numbers;
});

</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        My Warranty Edit
      </h1>
    </div>
  </header>
  <main>
    <div v-if="loading" class="px-5 py-4 flex justify-center"><button
        disabled
        type="button"
        class="py-10 px-10 me-2 text-2xl font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-yellow-400 focus:z-10 focus:ring-2 focus:ring-yellow-300 focus:text-yellow-500 inline-flex items-center"
      >
        <div role="status">
          <svg
            aria-hidden="true"
            class="inline w-8 h-8 me-2 text-gray-200 animate-spin fill-yellow-300"
            viewBox="0 0 100 101"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="currentColor"
            />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentFill"
            />
          </svg>
        </div>
        Loading...
      </button></div>
    <div v-else class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
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
              </g>
            </svg>
            Warranty ID</label
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
              />
            </svg>
            Invoice number</label
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

          <div v-if="valueInvoiceNumber" class="flex items-center mt-1">
            <input
              type="checkbox"
              id="getInvoiceNumberCheckbox"
              v-model="isCheckboxChecked"
              class="w-5 h-5 text-yellow-500 border-2 border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-300 transition-all duration-200 ease-in-out"
            />
            <label
              for="getInvoiceNumberCheckbox"
              class="ml-2 text-sm text-gray-700"
            >
              Add an already registered invoice number.
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
            ><svg
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
            ><svg
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

        <div class="mb-5">
          <label
            for="file_input"
            class="flex items-center mb-2 text-sm font-medium text-gray-900"
            ><svg
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
            >Warranty File</label
          >

          <input
            class="block w-full text-sm p-2 text-gray-900 border border-gray-300 hover:border-yellow-300 hover:border-2 rounded-lg cursor-pointer bg-white transition-colors duration-300 ease-in-out"
            id="file_input"
            type="file"
            @change="data.warranty_file = $event.target.files[0]"
            accept=".pdf,.docx,.jpg,.jpeg,.png"
          />

          <p class="text-xs text-gray-500 mt-1">
            Accepted formats: PDF, DOCX, JPG, JPEG, PNG
          </p>

          <p class="text-sm text-red-600">
            {{ errors && errors.warranty_file ? errors.warranty_file[0] : "" }}
          </p>
        </div>
        <button
          type="submit"
          class="text-gray-900 border-2 cursor-pointer border-yellow-300 bg-yellow-300 hover:bg-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
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
              d="M5 19h1.425L16.2 9.225L14.775 7.8L5 17.575zm-2 2v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM19 6.4L17.6 5zm-3.525 2.125l-.7-.725L16.2 9.225z"
            />
          </svg>
          Edit Warranty
        </button>
      </form>
    </div>
  </main>
</template>

<style scoped></style>
