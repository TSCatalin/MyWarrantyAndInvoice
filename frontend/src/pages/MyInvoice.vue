<script setup>
import { ref, watch } from "vue";
import router from "../router";
import { useRoute } from "vue-router";
import { TailwindPagination } from "laravel-vue-pagination";
import { useInvoiceStore } from "../store/invoiceStore";

const route = useRoute();
const invoiceStore = useInvoiceStore();

const sellers = ref([]);
const showFilters = ref(false);

const filters = ref({
  seller: "",
  product_name: "",
  sortBy: "",
});

const pagination = ref({
  current_page: 1,
  last_page: 1,
});

const fetchInvoiceData = async (page = 1) => {
  await invoiceStore.fetchAll(filters.value, page);

  sellers.value = invoiceStore.sellers || [];
  pagination.value.current_page = invoiceStore.pagination.current_page;
  pagination.value.last_page = invoiceStore.pagination.last_page;
};

const deleteInvoice = async (id) => {
  await invoiceStore.deleteInvoice(id);
};

const applyFilters = () => {
  router.push({ name: "MyInvoice", query: { ...filters.value, page: 1 } });
};

watch(
  () => route.query,
  (newQuery) => {
    const {
      seller = "",
      product_name = "",
      sortBy = "",
      page = "1",
    } = newQuery;

    filters.value = { seller, product_name, sortBy };
    const pageNumber = isNaN(parseInt(page)) ? 1 : parseInt(page);

    fetchInvoiceData(pageNumber);
  },
  { immediate: true }
);

const resetFilters = () => {
  filters.value = {
    seller: "",
    product_name: "",
    sortBy: "",
  };

  router.push({
    name: "MyInvoice",
    query: {
      page: 1,
    },
  });
};

const toggleFilterVisibility = () => {
  showFilters.value = !showFilters.value;
};

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
        Invoices
      </h1>
      <RouterLink
        :to="{ name: 'MyInvoice_Create' }"
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
        Add Invoice
      </RouterLink>
    </div>
  </header>
  <main>
    <div
      v-if="invoiceStore.loadingInvoice || sellers.length > 1"
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
                    @change="applyFilters"
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

                <div>
                  <select
                    v-model="filters.sortBy"
                    id="sortBy"
                    @change="applyFilters"
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
                      @keydown.enter="applyFilters"
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

    <div v-if="invoiceStore.loading" class="px-5 py-4 flex justify-center">
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
        v-if="invoiceStore.loadingInvoice"
        class="grid grid-cols-1 md:grid-cols-2 gap-8 p-4"
      >
        <div
          v-for="inov in invoiceStore.invoice.data"
          :key="inov.id"
          class="bg-white shadow-lg rounded-lg border-2 border-neutral-200 hover:border-yellow-400 transition-all duration-300 transform hover:scale-105 hover:shadow-xl"
        >
          <div class="px-6 py-5">
            <h3
              class="text-xl font-semibold text-gray-900 pb-2 flex items-center justify-between"
            >
              <div class="flex items-center">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.2em"
                  height="1.2em"
                  viewBox="0 0 24 24"
                  class="mr-2 text-yellow-300"
                >
                  <g
                    fill="none"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                  >
                    <path
                      stroke-dasharray="64"
                      stroke-dashoffset="64"
                      d="M13 3l6 6v12h-14v-18h8"
                    >
                      <animate
                        fill="freeze"
                        attributeName="stroke-dashoffset"
                        dur="0.6s"
                        values="64;0"
                      />
                    </path>
                    <path
                      stroke-dasharray="14"
                      stroke-dashoffset="14"
                      stroke-width="1"
                      d="M12.5 3v5.5h6.5"
                    >
                      <animate
                        fill="freeze"
                        attributeName="stroke-dashoffset"
                        begin="0.7s"
                        dur="0.2s"
                        values="14;0"
                      />
                    </path>
                  </g>
                </svg>
                {{ truncateProductName(inov.products_name) }}
              </div>
              <div class="text-sm text-gray-500">
                {{ inov.date_purchase }}
              </div>
            </h3>

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
                {{ inov.seller }}
              </div>
              <div class="flex items-center mb-2 text-base">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.2em"
                  height="1.2em"
                  viewBox="0 0 24 24"
                  class="mr-2 text-gray-500"
                >
                  <path
                    fill="currentColor"
                    d="M12 12.5a3.5 3.5 0 1 0 0 7a3.5 3.5 0 0 0 0-7M10.5 16a1.5 1.5 0 1 1 3 0a1.5 1.5 0 0 1-3 0"
                  />
                  <path
                    fill="currentColor"
                    d="M17.526 5.116L14.347.659L2.658 9.997L2.01 9.99V10H1.5v12h21V10h-.962l-1.914-5.599zM19.425 10H9.397l7.469-2.546l1.522-.487zM15.55 5.79L7.84 8.418l6.106-4.878zM3.5 18.169v-4.34A3 3 0 0 0 5.33 12h13.34a3 3 0 0 0 1.83 1.83v4.34A3 3 0 0 0 18.67 20H5.332A3.01 3.01 0 0 0 3.5 18.169"
                  />
                </svg>
                {{ inov.value }} {{ inov.currency }}
              </div>
            </div>

            <hr class="my-2 border-t-2 border-gray-200" />
            <div class="text-base font-medium text-gray-800">More details</div>

            <div class="ml-2">
              <div class="text-sm text-neutral-400 mb-1 flex">
                <div class="font-semibold me-1">• Invoice ID:</div>
                {{ inov.invoice_number }}
              </div>
              <div class="text-sm text-neutral-400 mb-1 flex">
                <div class="font-semibold me-1">• Customer Name:</div>
                {{ inov.customer_name }}
              </div>
            </div>

            <div class="pt-6 flex justify-center gap-4">
              <RouterLink
                class="px-4 py-2 text-center rounded-lg text-base font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
                :to="{ name: 'MyInvoice_Show', params: { id: inov.id } }"
              >
                Show
              </RouterLink>

              <RouterLink
                class="px-4 py-2 text-center rounded-lg text-base font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
                :to="{ name: 'MyInvoice_Edit', params: { id: inov.id } }"
              >
                Edit
              </RouterLink>

              <button
                @click="deleteInvoice(inov.id)"
                class="px-4 py-2 text-center rounded-lg text-base font-medium text-gray-900 bg-white border border-neutral-300 focus:outline-none hover:border-amber-300 hover:bg-yellow-300 hover:shadow-md transition-all duration-200 ease-in-out w-full sm:w-auto"
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
          You haven't added a invoice yet. Add a invoice using the button above
          "+ Add Invoice".
        </h3>
      </diV>
      <div
        v-else
        class="bg-white border border-neutral-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center items-center h-full mb-6"
      >
        <h3 class="text-base md:text-xl font-semibold text-black mb-2">
          No invoices were found that match these filters. Please reset the
          filters using the 'Reset Filters' button.
        </h3>
      </div>
      <div class="text-center py-2">
        <TailwindPagination
          :data="invoiceStore.invoice"
          @pagination-change-page="fetchInvoiceData"
        />
      </div>
    </div>
  </main>
</template>

<style scoped></style>
