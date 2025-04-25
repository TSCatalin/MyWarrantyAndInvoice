<script setup>
import { ref, onMounted } from "vue";
import axiosClient from "../axios";

const warranties = ref();
const warrantiesCount = ref();
const warrantiesMonth = ref();
const warrantiesAvailable = ref();
const warrantiesUnavailable = ref();

const loadingWarranties = ref(false);

onMounted(() => {
  axiosClient
    .get("/api/warranty/dashboardWarranty")
    .then((response) => {
      warranties.value = response.data.warranties;
      warrantiesCount.value = response.data.warranties_count;
      warrantiesMonth.value = response.data.warrantiesCountLastMonth;
      warrantiesAvailable.value = response.data.warranties_count_status_1;
      warrantiesUnavailable.value = response.data.warranties_count_status_0;
      if (warranties.value.length === 0) {
        loadingWarranties.value = false;
      } else {
        loadingWarranties.value = true;
      }
    })
    .catch((error) => {
      console.error(
        "Error retrieving warranty information:",
        error.response
      );
      if (error.response && error.response.status === 500) {
        console.error("Server error:", error.response.data);
      }
      if (error.response && error.response.status === 404) {
        router.push("/not-found");
      }
    });
});

const invoices = ref();
const invoicesCount = ref();
const invoicesMonth = ref();
const invoicesSum = ref();

const loadingInvoice = ref(false);

onMounted(() => {
  axiosClient
    .get("/api/invoice/dashboardInvoice")
    .then((response) => {
      invoices.value = response.data.invoices;
      invoicesCount.value = response.data.invoices_count;
      invoicesMonth.value = response.data.invoicesCountLastMonth;
      invoicesSum.value = response.data.sum_by_currency;

      if (invoices.value.length === 0) {
        loadingInvoice.value = false;
      } else {
        loadingInvoice.value = true;
      }
    })
    .catch((error) => {
      console.error(
        "Error retrieving invoice information:",
        error.response
      );
      if (error.response && error.response.status === 500) {
        console.error("Server error:", error.response.data);
      }
      if (error.response && error.response.status === 404) {
        router.push("/not-found");
      }
    });
});

const truncateProductName = (name) => {
  return name.length > 9 ? name.substring(0, 9) + "..." : name;
};
</script>

<template>
  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div class="text-center mb-8">
        <h1 class="text-3xl font-extrabold text-black">Dashboard</h1>
        <p class="mt-2 text-lg text-neutral-400">
          An overview of all your important information.
        </p>
      </div>

      <div
        v-if="!loadingWarranties && loadingInvoice"
        class="bg-white border border-yellow-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex justify-between items-center h-full mb-6"
      >
        <h3 class="text-sm md:text-xl font-semibold text-black">
          If you want more details, add a warranty
        </h3>
        <RouterLink
          :to="{ name: 'MyWarranty_Create' }"
          class="text-gray-900 bg-yellow-300 border-2 border-yellow-300 hover:bg-white focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-xl text-sm px-4 md:px-10 py-2.5 text-center inline-flex items-center me-1 mb-1"
        >
          Add Warranty
        </RouterLink>
      </div>

      <div
        v-if="!loadingInvoice && loadingWarranties"
        class="bg-white border border-yellow-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex justify-between items-center h-full mb-6"
      >
        <h3 class="text-sm md:text-xl font-semibold text-black">
          If you want more details, add a invoice
        </h3>
        <RouterLink
          :to="{ name: 'MyInvoice_Create' }"
          class="text-gray-900 bg-yellow-300 border-2 border-yellow-300 hover:bg-white focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-xl text-sm px-4 md:px-10 py-2.5 text-center inline-flex items-center me-1 mb-1"
        >
          Add Invoice
        </RouterLink>
      </div>

      <div
        v-if="!loadingInvoice && !loadingWarranties"
        class="bg-white border border-yellow-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center items-center h-full mb-6"
      >
        <h3 class="text-sm md:text-xl font-semibold text-black mb-2">
        To receive details on the dashboard page, you must first add a warranty or invoice.
        </h3>
        <RouterLink
          :to="{ name: 'MyInvoice_Create' }"
          class="text-gray-900 bg-yellow-300 border-2 border-yellow-300 hover:bg-white focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-xl text-sm px-4 md:px-10 py-2.5 text-center inline-flex items-center me-1 mb-1"
        >
          Add Invoice
        </RouterLink>
        <RouterLink
          :to="{ name: 'MyWarranty_Create' }"
          class="text-gray-900 bg-yellow-300 border-2 border-yellow-300 hover:bg-white focus:ring-4 focus:outline-none focus:ring-[#F7BE38]/50 font-medium rounded-xl text-sm px-4 md:px-10 py-2.5 text-center inline-flex items-center me-1 mb-1"
        >
          Add Warranty
        </RouterLink>
      </div>

      <div
        :class="[
          'grid',
          'grid-cols-2',
          'gap-2',
          'mb-8',
          loadingInvoice && loadingWarranties
            ? 'lg:grid-cols-4'
            : 'lg:grid-cols-2',
        ]"
      >
        <div
          v-if="loadingInvoice"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
        >
          <h3 class="text-base font-semibold text-black">Invoices</h3>
          <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
            {{ invoicesCount }}
          </p>
        </div>

        <div
          v-if="loadingInvoice"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
        >
          <h3 class="text-base font-semibold text-black">
            Invoices added this month.
          </h3>
          <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
            {{ invoicesMonth }}
          </p>
        </div>

        <div
          v-if="loadingWarranties"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
        >
          <h3 class="text-base font-semibold text-black">Warranties</h3>
          <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
            {{ warrantiesCount }}
          </p>
        </div>

        <div
          v-if="loadingWarranties"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
        >
          <h3 class="text-base font-semibold text-black">
            Warranties added this month.
          </h3>
          <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
            {{ warrantiesMonth }}
          </p>
        </div>
      </div>
      <div
        :class="[
          'sm:flex',
          loadingInvoice && loadingWarranties
            ? 'sm:justify-between'
            : 'sm:justify-center',
          'gap-2',
          'mx-auto',
          'max-w-7xl',
        ]"
      >
        <div
          v-if="loadingWarranties"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg p-2 text-center w-full sm:w-3/5"
        >
          <div class="w-full mb-4 mt-2">
            <h2 class="text-base font-semibold text-black">Warranty</h2>
          </div>

          <div class="flex gap-3">
            <div class="bg-white shadow-lg rounded-lg p-4 text-center w-full">
              <h3
                class="flex justify-center items-center text-xl font-semibold text-black"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="1.2em"
                  height="1.2em"
                  viewBox="0 0 10 10"
                  class="mr-2"
                >
                  <path
                    fill="currentColor"
                    d="M4.998 0a4.998 4.998 0 1 0 0 9.995a4.998 4.998 0 0 0 0-9.995M1 4.998a3.998 3.998 0 1 1 7.995 0a3.998 3.998 0 0 1-7.995 0m6.104-1.602a.5.5 0 0 1 0 .708l-2.25 2.25a.5.5 0 0 1-.708 0l-1-1a.5.5 0 1 1 .708-.708l.646.647l1.896-1.897a.5.5 0 0 1 .708 0"
                  /></svg
                >Available
              </h3>
              <p class="mt-2 text-2xl font-bold text-yellow-300">
                {{ warrantiesAvailable }}
              </p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 text-center w-full">
              <h3
                class="flex justify-center items-center text-xl sm:text-lg md:text-xl font-semibold text-black"
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
                    d="M12 20a8 8 0 0 1-8-8H2c0 5.523 4.477 10 10 10zm0-16a8 8 0 0 1 8 8h2c0-5.523-4.477-10-10-10zm-8 8a7.97 7.97 0 0 1 2.343-5.657L4.93 4.93A9.97 9.97 0 0 0 2 11.999zm2.343-5.657A7.97 7.97 0 0 1 12 4V2a9.97 9.97 0 0 0-7.071 2.929zm-1.414 0l12.728 12.728l1.414-1.414L6.343 4.929zM20 12a7.97 7.97 0 0 1-2.343 5.657l1.414 1.414A9.97 9.97 0 0 0 22 12zm-2.343 5.657A7.97 7.97 0 0 1 12 20v2a9.97 9.97 0 0 0 7.071-2.929z"
                  /></svg
                >Unavailable
              </h3>
              <p class="mt-2 text-2xl font-bold text-yellow-300">
                {{ warrantiesUnavailable }}
              </p>
            </div>
          </div>
        </div>

        <div
          v-if="loadingInvoice"
          class="bg-white shadow-md shadow-neutral-400 rounded-lg text-center sm:flex sm:justify-between items-center gap-6 w-full sm:w-2/5 p-2 mt-3 sm:mt-0"
        >
          <div class="bg-white rounded-lg text-center w-full h-full shadow-lg">
            <h3 class="text-base font-semibold text-black mt-2 mb-4">
              Invoice amounts
            </h3>
            <div class="bg-white rounded-lg text-center w-full">
              <div
                v-for="(item, index) in invoicesSum"
                :key="index"
                class="ml-4 flex justify-center text-xl text-black"
              >
                • {{ item.currency }} -
                <div class="text-yellow-400 ml-2 mb-2">{{ item.total }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="loadingWarranties" class="bg-white shadow-lg rounded-lg mt-4">
        <div class="p-4 ml-2">
          <h2 class="text-base font-semibold text-black">
            Last Warranty added
          </h2>
        </div>
        <div
          class="bg-white shadow-lg shadow-neutral-400 rounded-lg p-4 text-center flex flex-col justify-between h-full"
        >
          <table class="w-full text-sm text-left text-neutral-500">
            <thead
              className="text-xs text-black uppercase bg-white border-b-2 border-neutral-200"
            >
              <tr className="text-nowrap">
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Warranty ID
                </th>
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Product
                </th>
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Seller
                </th>
                <th className="px-2 py-3">Purchase Date</th>
              </tr>
            </thead>

            <tbody
              v-for="warra in warranties"
              :key="warra.id"
              class="border-b bg-neutral-200"
            >
              <tr class="border-b bg-neutral-200">
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(warra.warranty_id) }}
                </td>
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(warra.product_name) }}
                </td>
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(warra.seller) }}
                </td>
                <td className="px-2 py-2 bg-white border-b border-neutral-200">
                  {{ warra.date_purchase }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div v-if="loadingInvoice" class="bg-white shadow-lg rounded-lg mt-4">
        <div class="p-4 ml-2">
          <h2 class="text-base font-semibold text-black">Last Invoice added</h2>
        </div>
        <div
          class="bg-white shadow-lg shadow-neutral-400 rounded-lg p-4 text-center flex flex-col justify-between h-full"
        >
          <table class="w-full text-sm text-left text-neutral-500">
            <thead
              className="text-xs text-black uppercase bg-white border-b-2 border-neutral-200"
            >
              <tr className="text-nowrap">
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Invoice ID
                </th>
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Products
                </th>
                <th className="px-2 py-3 border-r-2 border-neutral-200">
                  Seller
                </th>
                <th className="px-2 py-3">Value</th>
              </tr>
            </thead>

            <tbody
              v-for="inov in invoices"
              :key="inov.id"
              class="border-b bg-neutral-200"
            >
              <tr class="border-b bg-neutral-200">
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(inov.invoice_number) }}
                </td>
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(inov.products_name) }}
                </td>
                <td
                  className="px-2 py-2 bg-white border-r-2 border-b border-neutral-200"
                >
                  {{ truncateProductName(inov.seller) }}
                </td>
                <td className="px-2 py-2 bg-white border-b border-neutral-200">
                  {{ truncateProductName(inov.value) }} {{ inov.currency }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
