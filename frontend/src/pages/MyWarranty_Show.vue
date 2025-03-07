<script setup>
import axiosClient from "../axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import router from "../router";

const warranty = ref({});

const route = useRoute();
const warrantyId = route.params.id;

onMounted(() => {
  axiosClient
    .get(`/api/warranty/${warrantyId}`)
    .then((response) => {
      console.log(response.data);
      warranty.value = response.data.data;
    })
    .catch((error) => {
      console.error("Eroare la preluarea garanției:", error.response);
      if (error.response && error.response.status === 500) {
        console.error("Server error:", error.response.data);
      }
      if (error.response && error.response.status === 404) {
        router.push("/not-found");
      }
    });
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
  console.log("TEST PDF");
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
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div
        class="bg-white overflow-hidden shadow rounded-lg border border-orange-100"
      >
        <div class="px-4 py-4">
          <div v-if="warranty.seller" class="text-sm text-gray-700 mb-2 flex">
            <div class="font-bold me-1">Product name:</div>
            {{ warranty.product_name }}
          </div>

          <div v-if="warranty.seller" class="text-sm text-gray-700 mb-2 flex">
            <div class="font-bold me-1">SELLER:</div>
            {{ warranty.seller }}
          </div>

          <div
            v-if="warranty.warranty_id"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Warranty ID:</div>
            {{ warranty.warranty_id }}
          </div>

          <div
            v-if="warranty.invoice_number"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Invoice ID:</div>
            {{ warranty.invoice_number }}
          </div>

          <div
            v-if="warranty.customer_name"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Customer Name:</div>
            {{ warranty.customer_name }}
          </div>

          <div
            v-if="warranty.date_purchase"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Purchase Date:</div>
            {{ warranty.date_purchase }}
          </div>
          <div
            v-if="warranty.invoice_number"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Warranty end Date:</div>
            {{ warranty.warranty_end_date }}
          </div>
          <div class="text-gray-700 mb-2 flex">
            <div class="font-bold me-1">Status:</div>
            <span
              v-if="warranty.status"
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

          <div class="text-sm text-gray-700 mb-2 flex items-center">
            <div class="font-bold me-1">Warranty File:</div>
            <div
              v-if="warranty && warranty.warranty_file"
              class="text-gray-900 bg-yellow-200 rounded-lg font-semibold text-sm px-2 py-1.5 text-center"
            >
              <div v-if="isImage(warranty.warranty_file)">
                <a :href="getImageSrc(warranty.warranty_file)" download
                  >Download the image</a
                >
              </div>
              <div v-else-if="isPDF(warranty.warranty_file)">
                <a :href="getPDFSrc(warranty.warranty_file)" download
                  >Download the PDF document</a
                >
              </div>
              <div v-else-if="isWord(warranty.warranty_file)">
                <a :href="getWordSrc(warranty.warranty_file)" download
                  >Download the Word document</a
                >
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
