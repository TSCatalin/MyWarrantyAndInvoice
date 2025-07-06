<script setup>
import { onMounted, ref } from "vue";
import { useRoute} from "vue-router";
import router from "../router";
import { useWarrantyStore } from "../store/warrantyStore";

const warrantyStore = useWarrantyStore();
const warranty = ref({});

const route = useRoute();
const warrantyId = route.params.id;
const loading = ref(true);

onMounted(async () => {
  const result = await warrantyStore.fetchWarranty(warrantyId);

  if (result.notFound) {
    router.push("/not-found");
  }

  if (result.serverError) {
    loading.value = false;
  }
  warranty.value = warrantyStore.warranty || {};
  loading.value = false;
});


const isImage = (file) => {
  if (file.startsWith("data:")) {
    return file.includes("image/");
  }

  if (file.startsWith("iVBORw0KGgoAAA")) {
    return true;
  } else if (file.startsWith("/9j/4AAQ")) {
    return true;
  }
  return false;
};

const isPDF = (file) => {
  if (file.startsWith("data:application/pdf")) {
    return true;
  }

  if (file.startsWith("JVBERi0xL")) {
    return true;
  }

  return false;
};

const isWord = (file) => {
  if (
    file.startsWith("data:application/msword") ||
    file.startsWith(
      "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    )
  ) {
    return true;
  }

  if (file.startsWith("D0CF11E0A1B11AE1")) {
    return true;
  }

  if (file.startsWith("UEsDBB")) {
    return true;
  }
  return false;
};

const getImageSrc = (file) => {
  if (file.startsWith("data:image/")) {
    return file;
  }

  if (file.startsWith("iVBORw0KGgoAAA")) {
    return "data:image/png;base64," + file;
  } else if (file.startsWith("/9j/4AAQ")) {
    return "data:image/jpeg;base64," + file;
  }

  return "data:image/png;base64," + file;
};

const getPDFSrc = (file) => {
  if (file.startsWith("JVBERi0xL")) {
    return "data:application/pdf;base64," + file;
  }

  if (file.startsWith("data:application/pdf;base64,")) {
    return file;
  }

  return "";
};

const getWordSrc = (file) => {
  if (
    file.startsWith("data:application/msword") ||
    file.startsWith(
      "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document"
    )
  ) {
    return file;
  }

  if (file.startsWith("D0CF11E0A1B11AE1")) {
    return "data:application/msword;base64," + file;
  }

  if (file.startsWith("UEsDBB")) {
    return (
      "data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64," +
      file
    );
  }

  return "data:application/msword;base64," + file;
};
</script>

<template>
  <header class="bg-white shadow">
    <div
      class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between"
    >
      <h1 class="text-2xl font-bold tracking-tight text-gray-900">
        {{ warranty.product_name }}
      </h1>
    </div>
  </header>

  <main>
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
    <div v-else class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div
        class="bg-white overflow-hidden shadow rounded-xl border-2 border-neutral-300 p-6"
      >
        <div class="text-gray-700 mb-4 flex">
          <span
            v-if="warranty.status"
            class="inline-flex items-center bg-green-200 text-green-800 text-base font-medium px-4 py-4 rounded-xl"
          >
            <span class="w-3 h-3 me-2 bg-green-500 rounded-full"></span>
            Available
          </span>

          <span
            v-else
            class="inline-flex items-center bg-red-200 text-red-800 text-base font-medium px-4 py-4 rounded-xl"
          >
            <span class="w-3 h-3 me-2 bg-red-500 rounded-full"></span>
            Unavailable
          </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div
            v-if="warranty.product_name"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="font-medium text-neutral-700 flex">
              <svg
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
              >Product Name
            </div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.product_name }}
            </div>
          </div>

          <div
            v-if="warranty.seller"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700">
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
              >Seller
            </div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.seller }}
            </div>
          </div>

          <div
            v-if="warranty.warranty_id"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700">
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
              >Warranty ID
            </div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.warranty_id }}
            </div>
          </div>

          <div
            v-if="warranty.invoice_number"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700">
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
              >Invoice ID
            </div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.invoice_number }}
            </div>
          </div>

          <div
            v-if="warranty.date_purchase"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700"><svg
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
          >Purchase Date</div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.date_purchase }}
            </div>
          </div>

          <div
            v-if="warranty.warranty_end_date"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700"><svg
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
          >Warranty end Date</div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.warranty_end_date }}
            </div>
          </div>

          <div
            v-if="warranty.customer_name"
            class="bg-white p-6 rounded-xl shadow-md border-2 border-neutral-300 hover:border-yellow-300"
          >
            <div class="flex font-medium text-neutral-700"><svg
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
          >Customer Name</div>
            <div class="text-lg font-semibold text-neutral-900">
              {{ warranty.customer_name }}
            </div>
          </div>
        </div>
        <div
          class="text-sm text-gray-700 mb-4 flex items-start flex-col space-y-4 py-4"
        >
          <div
            v-if="warranty && warranty.warranty_file"
            class="w-full bg-neutral-100 rounded-lg p-4 shadow-sm"
          >
            <div class="font-bold text-lg">Warranty file</div>
            <div
              v-if="isImage(warranty.warranty_file)"
              class="flex flex-col items-center"
            >
              <img
                :src="getImageSrc(warranty.warranty_file)"
                alt="Warranty File"
                class="w-full sm:w-80 md:w-96 lg:w-1/2 h-auto mb-2 rounded-lg shadow-sm"
              />
              <a
                :href="getImageSrc(warranty.warranty_file)"
                download
                class="text-yellow-400 hover:underline mt-2 block text-center"
                >Download the image</a
              >
            </div>

            <div v-else-if="isPDF(warranty.warranty_file)">
              <iframe
                :src="getPDFSrc(warranty.warranty_file)"
                class="w-full h-96 mb-2 rounded-lg shadow-sm pt-2"
                title="Warranty PDF"
              ></iframe>
              <a
                :href="getPDFSrc(warranty.warranty_file)"
                download
                class="text-yellow-400 hover:underline mt-2 block text-center"
                >Download the PDF document</a
              >
            </div>

            <div v-else-if="isWord(warranty.warranty_file)">
              <p class="mb-2 text-center">
                This is a Word document. You can download it below:
              </p>
              <a
                :href="getWordSrc(warranty.warranty_file)"
                download
                class="text-yellow-400 hover:underline mt-2 block text-center"
                >Download the Word document</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
