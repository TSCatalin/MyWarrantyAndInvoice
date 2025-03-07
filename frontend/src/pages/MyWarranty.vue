<script setup>
import axiosClient from "../axios";
import { onMounted, ref, watch } from "vue";
import router from "../router";
import { useRoute } from "vue-router";

const warranty = ref([]);
const sellers = ref([]);
const status = ref([]);

const route = useRoute();

function deleteImage(id) {
  if (!confirm("Are you sure you want to delete this Warranty?")) {
    return;
  }
  console.log(id);
  axiosClient.delete(`/api/warranty/${id}`).then((response) => {
    location.reload();
  });
}

const loading = ref(true);

const filters = ref({
  seller: "",
  status: "",
  product_name: "",
});

onMounted(() => {
  let params = {
    seller: filters.value.seller,
    status: filters.value.status,
    product_name: filters.value.product_name,
  };
  console.log("DIN ON MOUNTED");
  axiosClient
    .get("/api/warranty", { params })
    .then((response) => {
      warranty.value = response.data;
      sellers.value = response.data.seller;
      status.value = response.data.status;
      loading.value = false;
    })
    .catch((error) => {
      console.error("Error fetching sellers data:", error);
      loading.value = false;
    });
});

const fetchWarrantyData = () => {
  let params = {
    seller: filters.value.seller,
    status: filters.value.status,
    product_name: filters.value.product_name,
  };

  router.push({
    path: "/warranty",
    query: params,
  });
  console.log("DIN ON FETCH WARRANTY");
  axiosClient
    .get("/api/warranty", { params })
    .then((response) => {
      console.log(response.data);
      warranty.value = response.data;
      sellers.value = response.data.seller;
      status.value = response.data.status;
      loading.value = false;
    })
    .catch((error) => {
      console.error("Error fetching warranty data:", error);
      loading.value = false;
    });
};

const resetFilters = () => {
  filters.value.seller = "";
  filters.value.status = "";
  filters.value.product_name = "";

  router.push({
    path: "/warranty",
    query: {},
  });

  fetchWarrantyData();
};

watch(
  () => route.query,
  (newQuery) => {
    filters.value.seller = newQuery.seller || "";
    filters.value.status = newQuery.status || "";
    filters.value.product_name = newQuery.product_name || "";
    fetchWarrantyData(); 
  { immediate: true }
);

const updateFiltersAndUrl = () => {
  const params = {
    seller: filters.value.seller,
    status: filters.value.status,
    product_name: filters.value.product_name,
  };
  router.push({ query: params });
};

watch(filters, () => {
  updateFiltersAndUrl();
});
</script>

<template>
  <header class="bg-white shadow">
    <div
      class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between"
    >
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        Warranty
      </h1>
      <RouterLink
        :to="{ name: 'MyWarranty_Create' }"
        class="text-gray-900 bg-[#F7BE38] hover:bg-[#F7BE38]/90 focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#F7BE38]/50 me-2 mb-2"
      >
        Add Warranty
      </RouterLink>
    </div>
  </header>
  <main>
    <div class="py-2">
      <div
        class="items-center justify-center grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 px-[calc(5%)] md:px-[calc(10%)] lg:px-[calc(12%)]"
      >
        <div class="rounded-lg">
          <select
            v-model="filters.seller"
            id="seller"
            @change="fetchWarrantyData"
            class="text-neutral-400 p-3.5 border border-gray-300 rounded-lg focus:border-amber-300 bg-gray-50"
          >
            <option value="" class="text-gray-300 hover:border-amber-300">
              Select Seller
            </option>
            <option
              v-for="seller in sellers"
              :key="seller"
              :value="seller"
              class="text-neutral-400 bg-gray-50 hover:border-amber-300 selection:border-amber-300"
            >
              {{ seller }}
            </option>
          </select>
        </div>

        <div v-if="status.length > 1" class="rounded-lg">
          <select
            v-model="filters.status"
            id="status"
            @change="fetchWarrantyData"
            class="text-neutral-400 p-3.5 border border-gray-300 rounded-lg focus:border-amber-300 bg-gray-50"
          >
            <option value="" class="text-gray-300 hover:border-amber-300">
              Select Status
            </option>
            <option
              v-for="sta in status"
              :key="sta"
              :value="sta"
              class="text-neutral-400 bg-gray-50 hover:border-amber-300 selection:border-amber-300"
            >
              {{ sta === 0 ? "Unavailable" : "Available" }}
            </option>
          </select>
        </div>

        <div class="relative border bg-gray-50 border-gray-300 rounded-lg">
          <div
            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
          >
            <svg
              class="w-4 h-4 text-gray-500"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 20 20"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
              />
            </svg>
          </div>
          <div class="flex items-center pr-2">
            <input
              type="search"
              id="default-search"
              class="block w-full p-4 ps-10 text-sm text-gray-900 has-checked:border-amber-300 placeholder:border-amber-300 focus:border-amber-300"
              placeholder="Search Product"
              v-model="filters.product_name"
            />
            <button
              type="button"
              @click="fetchWarrantyData"
              class="text-white bg-[#F7BE38] hover:bg-amber-500 font-medium rounded-lg text-sm px-1.5 py-2"
            >
              Search
            </button>
          </div>
        </div>
        <div class="">
          <button
            type="button"
            @click="resetFilters"
            class="text-white bg-neutral-400 hover:bg-neutral-500 font-medium rounded-lg text-sm mt-4 p-2"
          >
            Reset Filters
          </button>
        </div>
      </div>
    </div>
    <div v-if="loading" class="px-5 py-4 flex justify-center">
      <button
        disabled
        type="button"
        class="py-10 px-10 me-2 text-2xl font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-amber-400 focus:z-10 focus:ring-2 focus:ring-amber-300 focus:text-amber-500-700 inline-flex items-center"
      >
        <div role="status">
          <svg
            aria-hidden="true"
            class="inline w-8 h-8 me-2 text-gray-200 animate-spin fill-amber-300"
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
      </button>
    </div>
    <div v-else class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="warra in warranty.data"
          :key="warra.id"
          class="bg-white overflow-hidden shadow rounded-lg border border-orange-100"
        >
          <div class="px-4 py-4">
            <h3 class="text-lg font-semibold text-gray-900">
              {{ warra.product_name }}
            </h3>
            <div class="text-sm text-gray-700 mb-1 flex">
              <div class="font-bold me-1">SELLER:</div>
              {{ warra.seller }}
            </div>
            <div class="text-sm text-gray-700 mb-1 flex">
              <div class="font-bold me-1">Warranty ID:</div>
              {{ warra.warranty_id }}
            </div>
            <div class="text-sm text-gray-700 mb-1 flex">
              <div class="font-bold me-1">Invoice ID:</div>
              {{ warra.invoice_number }}
            </div>
            <div class="text-sm text-gray-700 mb-1 flex">
              <div class="font-bold me-1">Customer Name:</div>
              {{ warra.customer_name }}
            </div>
            <div class="text-sm text-gray-700 mb-1 flex">
              <div class="font-bold me-1">Date Purchase:</div>
              {{ warra.date_purchase }}
            </div>

            <div class="text-gray-700 mb-1 flex">
              <div class="font-bold me-1">Status:</div>
              <span
                v-if="warra.status"
                class="inline-flex items-center bg-green-200 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded-full"
              >
                <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                Available
              </span>

              <span
                v-else
                class="inline-flex items-center bg-red-200 text-red-800 text-xs font-medium px-2.5 py-1.5 rounded-full"
              >
                <span class="w-2 h-2 me-1 bg-red-500 rounded-full"></span>
                Unavailable
              </span>
            </div>
            <div class="py-3">
              <div class="inline-flex rounded-md shadow-xs" role="group">
                <router-link
                  type="button"
                  class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-[#F7BE38]/90 focus:z-10 focus:ring-2 focus:ring-[#F7BE38]/50 focus:text-amber-300"
                  :to="{ name: 'MyWarranty_Show', params: { id: warra.id } }"
                >
                  Show
                </router-link>
                <router-link
                  type="button"
                  class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-[#F7BE38]/90 focus:z-10 focus:ring-2 focus:ring-[#F7BE38]/50 focus:text-amber-300"
                  :to="{ name: 'MyWarranty_Edit', params: { id: warra.id } }"
                >
                  Edit
                </router-link>
                <button
                  type="button"
                  @click="deleteImage(warra.id)"
                  class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-[#F7BE38]/90 focus:z-10 focus:ring-2 focus:ring-[#F7BE38]/50 focus:text-amber-300"
                >
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
