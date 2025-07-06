<script setup>
import { ref, onMounted } from "vue";
import { useWarrantyStore } from "../store/warrantyStore";
import { useInvoiceStore } from "../store/invoiceStore";

const warrantyStore = useWarrantyStore();
const invoiceStore = useInvoiceStore();
const loadingW = ref(true);
const loadingI = ref(true);

onMounted(async () => {
  await warrantyStore.fetchDashboardWarranties();
  loadingW.value = false;
});

onMounted(async () => {
  await invoiceStore.fetchDashboardInvoices();
  loadingI.value = false;
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

      <div v-if="loadingW && loadingI" class="px-5 py-4 flex justify-center">
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

      <div v-else>
        <div
          v-if="!warrantyStore.loadingWarranties && invoiceStore.loadingInvoice"
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
          v-if="!invoiceStore.loadingInvoice && warrantyStore.loadingWarranties"
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
          v-if="
            !invoiceStore.loadingInvoice && !warrantyStore.loadingWarranties
          "
          class="bg-white border border-yellow-300 shadow-md shadow-neutral-400 rounded-lg p-6 text-center items-center h-full mb-6"
        >
          <h3 class="text-sm md:text-xl font-semibold text-black mb-2">
            To receive details on the dashboard page, you must first add a
            warranty or invoice.
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
            invoiceStore.loadingInvoice && warrantyStore.loadingWarranties
              ? 'lg:grid-cols-4'
              : 'lg:grid-cols-2',
          ]"
        >
          <div
            v-if="invoiceStore.loadingInvoice"
            class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
          >
            <h3 class="text-base font-semibold text-black">Invoices</h3>
            <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
              {{ invoiceStore.invoicesCount }}
            </p>
          </div>

          <div
            v-if="invoiceStore.loadingInvoice"
            class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
          >
            <h3 class="text-base font-semibold text-black">
              Invoices added this month.
            </h3>
            <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
              {{ invoiceStore.invoicesMonth }}
            </p>
          </div>

          <div
            v-if="warrantyStore.loadingWarranties"
            class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
          >
            <h3 class="text-base font-semibold text-black">Warranties</h3>
            <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
              {{ warrantyStore.warrantiesCount }}
            </p>
          </div>

          <div
            v-if="warrantyStore.loadingWarranties"
            class="bg-white shadow-md shadow-neutral-400 rounded-lg p-6 text-center flex flex-col justify-between h-full"
          >
            <h3 class="text-base font-semibold text-black">
              Warranties added this month.
            </h3>
            <p class="mt-2 text-xl font-bold text-yellow-300 mb-0">
              {{ warrantyStore.warrantiesMonth }}
            </p>
          </div>
        </div>
        <div
          :class="[
            'sm:flex',
            invoiceStore.loadingInvoice && warrantyStore.loadingWarranties
              ? 'sm:justify-between'
              : 'sm:justify-center',
            'gap-2',
            'mx-auto',
            'max-w-7xl',
          ]"
        >
          <div
            v-if="warrantyStore.loadingWarranties"
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
                  {{ warrantyStore.warrantiesAvailable }}
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
                  {{ warrantyStore.warrantiesUnavailable }}
                </p>
              </div>
            </div>
          </div>

          <div
            v-if="invoiceStore.loadingInvoice"
            class="bg-white shadow-md shadow-neutral-400 rounded-lg text-center sm:flex sm:justify-between items-center gap-6 w-full sm:w-2/5 p-2 mt-3 sm:mt-0"
          >
            <div
              class="bg-white rounded-lg text-center w-full h-full shadow-lg"
            >
              <h3 class="text-base font-semibold text-black mt-2 mb-4">
                Invoice amounts
              </h3>
              <div class="bg-white rounded-lg text-center w-full">
                <div
                  v-for="(item, index) in invoiceStore.invoicesSum"
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
        <div
          v-if="warrantyStore.loadingWarranties"
          class="bg-white shadow-lg rounded-lg mt-4"
        >
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
                v-for="warra in warrantyStore.warranties"
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
                  <td
                    className="px-2 py-2 bg-white border-b border-neutral-200"
                  >
                    {{ warra.date_purchase }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div
          v-if="invoiceStore.loadingInvoice"
          class="bg-white shadow-lg rounded-lg mt-4"
        >
          <div class="p-4 ml-2">
            <h2 class="text-base font-semibold text-black">
              Last Invoice added
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
                v-for="inov in invoiceStore.invoices"
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
                  <td
                    className="px-2 py-2 bg-white border-b border-neutral-200"
                  >
                    {{ truncateProductName(inov.value) }} {{ inov.currency }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
