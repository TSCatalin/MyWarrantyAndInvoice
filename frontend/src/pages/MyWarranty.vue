<script setup>
import axiosClient from "../axios";
import { onMounted, ref, watch } from "vue";
import router from "../router";
import { useRoute } from "vue-router";
import { TailwindPagination } from "laravel-vue-pagination";

const sellers = ref([]);
const status = ref([]);
const warranty = ref([]);

const pagination = ref({
  current_page: 1,
  last_page: 1,
});

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
const loadingWarranties = ref(false);

const showFilters = ref(false);

const filters = ref({
  seller: "",
  status: "",
  product_name: "",
  sortBy: "",
});

onMounted(() => {
  fetchWarrantyData();
});

const toggleFilterVisibility = () => {
  showFilters.value = !showFilters.value;
};

const fetchWarrantyData = (page = 1) => {
  let params = {
    seller: filters.value.seller,
    status: filters.value.status,
    product_name: filters.value.product_name,
    sortBy: filters.value.sortBy,
    page: page,
  };

  router.push({
    name: "MyWarranty",
    query: { ...params, page: page },
  });
  console.log("DIN ON FETCH WARRANTY");

  axiosClient
    .get("/api/warranty", { params })
    .then((response) => {
      warranty.value = response.data;
      sellers.value = response.data.seller;
      status.value = response.data.status;
      pagination.value.current_page = response.data.meta.current_page;
      pagination.value.last_page = response.data.meta.last_page;

      if (warranty.value.data.length === 0) {
        loadingWarranties.value = false;
      } else {
        loadingWarranties.value = true;
      }

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
  filters.value.sortBy = "";
  router.push({
    name: "MyWarranty",
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
    filters.value.sortBy = newQuery.sortBy || "";
    fetchWarrantyData();
  },
  { immediate: true }
);

const truncateProductName = (name) => {
  return name.length > 11 ? name.substring(0, 11) + "..." : name;
};

</script>

<template>
  <header class="bg-white shadow">
    <div
      class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8 flex justify-between"
    >
      <h1
        class="text-2xl flex text-center items-center font-bold text-gray-900"
      >
        Warranty
      </h1>
      <RouterLink
        :to="{ name: 'MyWarranty_Create' }"
        class="text-gray-900 bg-yellow-300 border-2 border-yellow-300 hover:bg-white focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-xl text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          height="24px"
          viewBox="0 -960 960 960"
          width="24px"
          fill="#000000"
          class="mr-2"
        >
          <path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" />
        </svg>
        Add Warranty
      </RouterLink>
    </div>
  </header>
  <main>
    <div
      v-if="loadingWarranties || sellers.length > 1"
      class="max-w-7xl mx-auto"
    >
      <div class="bg-white shadow-lg pl-4 sm:pl-12 pr-12 pb-2 pt-2">
        <div class="space-y-4">
          <div class="bg-white rounded-lg">
            <button
              @click="toggleFilterVisibility"
              class="w-40 flex justify-between border-2 border-dashed border-neutral-100 items-center p-2 text-lg font-medium text-black rounded-lg bg-neutral-100 hover:bg-white hover:border-neutral-200"
            >
              {{ showFilters ? "Hide Filters" : "Show Filters" }}
              <svg
                v-if="!showFilters"
                xmlns="http://www.w3.org/2000/svg"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 24 24"
                class="ml-2"
              >
                <path
                  fill="currentColor"
                  d="M21.886 5.536A1 1 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13a.998.998 0 0 0 1.644 0l9-13a1 1 0 0 0 .064-1.033M12 17.243L4.908 7h14.184z"
                />
              </svg>

              <svg
                v-if="showFilters"
                xmlns="http://www.w3.org/2000/svg"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 24 24"
                class="ml-2"
              >
                <path
                  fill="currentColor"
                  d="M3 19h18a1.002 1.002 0 0 0 .823-1.569l-9-13c-.373-.539-1.271-.539-1.645 0l-9 13A.999.999 0 0 0 3 19m9-12.243L19.092 17H4.908z"
                />
              </svg>
            </button>

            <div v-if="showFilters" class="p-4">
              <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
              >
                <div v-if="sellers.length > 0">
                  <select
                    v-model="filters.seller"
                    id="seller"
                    @change="fetchWarrantyData"
                    class="w-full p-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-200 bg-white text-black"
                  >
                    <option value="" class="text-gray-300">
                      Select Seller
                    </option>
                    <option
                      v-for="seller in sellers"
                      :key="seller"
                      :value="seller"
                      class="text-neutral-400 bg-white hover:bg-yellow-300 hover:text-black"
                    >
                      {{ seller }}
                    </option>
                  </select>
                </div>

                <div v-if="status.length > 1">
                  <select
                    v-model="filters.status"
                    id="status"
                    @change="fetchWarrantyData"
                    class="w-full p-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-200 bg-white text-black"
                  >
                    <option value="" class="text-gray-300">
                      Select Status
                    </option>
                    <option
                      v-for="sta in status"
                      :key="sta"
                      :value="sta"
                      class="text-neutral-400 bg-white hover:bg-yellow-200 hover:text-black"
                    >
                      {{ sta === 0 ? "Unavailable" : "Available" }}
                    </option>
                  </select>
                </div>

                <div>
                  <select
                    v-model="filters.sortBy"
                    id="sortBy"
                    @change="fetchWarrantyData"
                    class="w-full p-3.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-200 bg-white text-black"
                  >
                    <option value="" class="text-gray-300">Sort by</option>
                    <option
                      value="purchase_ASC"
                      class="text-neutral-400 hover:bg-yellow-200 hover:text-black"
                    >
                      Ascending purchase dates
                    </option>
                    <option
                      value="purchase_DESC"
                      class="text-neutral-400 hover:bg-yellow-200 hover:text-black"
                    >
                      Descending purchase dates
                    </option>
                    <option
                      value="warranty_end_ASC"
                      class="text-neutral-400 hover:bg-yellow-200 hover:text-black"
                    >
                      Ascending warranty end dates
                    </option>
                    <option
                      value="warranty_end_DESC"
                      class="text-neutral-400 hover:bg-yellow-200 hover:text-black"
                    >
                      Descending warranty end dates
                    </option>
                  </select>
                </div>

                <div class="relative">
                  <div
                    class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
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

                  <div class="flex items-center relative w-full">
                    <svg
                      class="absolute left-3 w-4 h-4 text-gray-500"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 20 20"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 4a4 4 0 1 1 0 8 4 4 0 0 1 0-8zM12 12l5 5"
                      />
                    </svg>

                    <input
                      type="search"
                      id="default-search"
                      class="block w-full pl-10 pr-4 py-4 text-sm bg-white text-black placeholder:text-gray-500 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-200"
                      placeholder="Search Product"
                      v-model="filters.product_name"
                      @keydown.enter="fetchWarrantyData"
                    />
                  </div>
                </div>

                <div class="flex justify-start mt-4">
                  <button
                    type="button"
                    @click="resetFilters"
                    class="text-black bg-neutral-200 hover:bg-neutral-300 font-medium rounded-lg text-sm p-2"
                  >
                    Reset Filters
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="px-5 py-4 flex justify-center">
      <button
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
      </button>
    </div>
    <div v-else class="px-4 py-6 sm:px-24 md:px-6 lg:px-10">
      <div
        v-if="loadingWarranties"
        class="grid grid-cols-1 md:grid-cols-2 gap-8 p-4"
      >
        <div
          v-for="warra in warranty.data"
          :key="warra.id"
          class="bg-white shadow-lg rounded-lg border-2 border-neutral-200 hover:border-yellow-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
        >
          <div class="p-6">
            <h3
              class="text-xl font-semibold text-gray-900 pb-2 flex items-center justify-between"
            >
              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.5em"
                  height="1.5em"
                  viewBox="0 0 2048 2048"
                  class="mr-3 text-yellow-300"
                >
                  <path
                    fill="currentColor"
                    d="m960 120l832 416v1040l-832 415l-832-415V536zm625 456L960 264L719 384l621 314zM960 888l238-118l-622-314l-241 120zM256 680v816l640 320v-816zm768 1136l640-320V680l-640 320z"
                  />
                </svg>
                {{ truncateProductName(warra.product_name) }}
              </div>
              <div class="text-sm text-gray-500">
                {{ warra.date_purchase }}
              </div>
            </h3>
            <div class="text-gray-700 mt-2 flex items-center">
              <span
                v-if="warra.status"
                class="inline-flex items-center bg-green-200 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded-full"
              >
                <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                Available
              </span>
              <span
                v-else
                class="inline-flex items-center bg-red-200 text-red-800 text-xs font-medium px-2.5 py-1.5 rounded-full"
              >
                <span class="w-2 h-2 mr-1 bg-red-500 rounded-full"></span>
                Unavailable
              </span>
            </div>
            <div class="text-sm text-gray-700 mb-2 mt-4">
              <div class="flex items-center mb-2">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.2em"
                  height="1.2em"
                  viewBox="0 0 24 24"
                  class="mr-2 text-gray-500"
                >
                  <path
                    fill="currentColor"
                    d="M4 6V4h16v2zm0 14v-6H3v-2l1-5h16l1 5v2h-1v6h-2v-6h-4v6zm2-2h6v-4H6zm-.95-6h13.9zm0 0h13.9l-.6-3H5.65z"
                  />
                </svg>
                {{ warra.seller }}
              </div>

              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.2em"
                  height="1.2em"
                  viewBox="0 0 24 24"
                  class="mr-2"
                >
                  <path
                    fill="currentColor"
                    d="M21 17h3l-4 4l-4-4h3V3h2zM8 16h3v-3H8zm5-11h-1V3h-2v2H6V3H4v2H3c-1.11 0-2 .89-2 2v11c0 1.11.89 2 2 2h10c1.11 0 2-.89 2-2V7c0-1.11-.89-2-2-2M3 18v-7h10v7z"
                  />
                </svg>
                {{ warra.warranty_end_date }}
              </div>
            </div>
            <hr class="my-2 border-t-2 border-gray-200" />
            <div class="text-base font-medium text-gray-800">More details</div>

            <div class="ml-2">
              <div class="text-sm text-neutral-400 mb-1 flex">
                <div class="font-semibold me-1">• Warranty ID:</div>
                {{ warra.warranty_id }}
              </div>
              <div class="text-sm text-neutral-400 mb-1 flex">
                <div class="font-semibold me-1">• Invoice ID:</div>
                {{ warra.invoice_number }}
              </div>
              <div class="text-sm text-neutral-400 mb-1 flex">
                <div class="font-semibold me-1">• Customer Name:</div>
                {{ warra.customer_name }}
              </div>
            </div>

            <div class="pt-6 flex justify-center gap-4">
              <RouterLink
                class="px-4 py-2 text-center rounded-lg text-base font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
                :to="{ name: 'MyWarranty_Show', params: { id: warra.id } }"
              >
                Show
              </RouterLink>

              <RouterLink
                class="px-4 py-2 text-center rounded-lg text-base font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
                :to="{ name: 'MyWarranty_Edit', params: { id: warra.id } }"
              >
                Edit
              </RouterLink>

              <button
                type="button"
                @click="deleteImage(warra.id)"
                class="px-4 py-2 ml-3 text-base rounded-lg font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>
      <diV
        v-else-if="sellers.length < 1"
        class="bg-white border border-neutral-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center items-center h-full mb-6"
      >
        <h3 class="text-base md:text-xl font-semibold text-black mb-2">
          You haven't added a warranty yet. Add a warranty using the button
          above "+ Add Warranty".
        </h3>
      </diV>
      <div
        v-else
        class="bg-white border border-neutral-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center items-center h-full mb-6"
      >
        <h3 class="text-base md:text-xl font-semibold text-black mb-2">
          No warranties were found that match these filters. Please reset the
          filters using the 'Reset Filters' button.
        </h3>
      </div>
      <div class="text-center py-2">
        <TailwindPagination
          :data="warranty"
          @pagination-change-page="fetchWarrantyData"
        />
      </div>
    </div>
  </main>
</template>

<style scoped></style>
