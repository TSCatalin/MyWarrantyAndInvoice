<script setup>
import axiosClient from "../axios";
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import router from "../router";

const invoice = ref({});

const route = useRoute();
const invoiceId = route.params.id;

onMounted(() => {
  axiosClient
    .get(`/api/invoice/${invoiceId}`)
    .then((response) => {
      console.log(response.data);
      invoice.value = response.data.data;
    })
    .catch((error) => {
      console.error("Eroare la preluarea facturi:", error.response);
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
    // PNG
    return true;
  } else if (file.startsWith("/9j/4AAQ")) {
    // JPG
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
        {{ invoice.products_name }}
      </h1>
    </div>
  </header>

  <main>
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div
        class="bg-white overflow-hidden shadow rounded-lg border border-orange-100"
      >
        <div class="px-4 py-4">
          <div v-if="invoice.seller" class="text-sm text-gray-700 mb-2 flex">
            <div class="font-bold me-1">Products name:</div>
            {{ invoice.products_name }}
          </div>

          <div v-if="invoice.seller" class="text-sm text-gray-700 mb-2 flex">
            <div class="font-bold me-1">SELLER:</div>
            {{ invoice.seller }}
          </div>

          <div
            v-if="invoice.invoice_number"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Invoice ID:</div>
            {{ invoice.invoice_number }}
          </div>

          <div
            v-if="invoice.customer_name"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Customer Name:</div>
            {{ invoice.customer_name }}
          </div>

          <div
            v-if="invoice.value"
            class="text-sm text-gray-700 mb-2 flex "
          >
            <div class="font-bold me-1">Value:</div>
            <div class="underline underline-offset-2">{{ invoice.value }}  {{invoice.currency}}  </div>
            
          </div>

          <div
            v-if="invoice.date_purchase"
            class="text-sm text-gray-700 mb-2 flex"
          >
            <div class="font-bold me-1">Purchase Date:</div>
            {{ invoice.date_purchase }}
          </div>
          <div class="text-sm text-gray-700 mb-2 flex items-center">
            <div class="font-bold me-1">Invoice File:</div>
            <div
              v-if="invoice && invoice.invoice_file"
              class="text-gray-900 bg-yellow-200 rounded-lg font-semibold text-sm px-2 py-1.5 text-center"
            >
              <div v-if="isImage(invoice.invoice_file)">
                <a :href="getImageSrc(invoice.invoice_file)" download
                  >Download the image</a
                >
              </div>
              <div v-else-if="isPDF(invoice.invoice_file)">
                <a :href="getPDFSrc(invoice.invoice_file)" download
                  >Download the PDF document</a
                >
              </div>
              <div v-else-if="isWord(invoice.invoice_file)">
                <a :href="getWordSrc(invoice.invoice_file)" download
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
