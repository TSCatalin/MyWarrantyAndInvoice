<template>
  <div class="bg-white px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <div class="pt-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-24 pb-14">
        <div
          class="text-black text-5xl font-bold underline underline-offset-4 decoration-yellow-300"
        >
          FAQ
        </div>
        <p class="mt-6 text-lg/8 text-gray-600">Frequenty asked questions</p>
      </div>
      <div class="mx-auto pb-20 grid max-w-xl divide-y divide-neutral-200">
        <div v-for="(item, index) in faqItems" :key="index" class="py-5">
          <details class="group">
            <summary
              class="flex cursor-pointer list-none items-left-panel justify-between font-medium"
            >
              <span
                class="hover:underline decoration-yellow-300 underline-offset-2 text-justify mr-4"
                >{{ item.question }}</span
              >
              <span class="transition group-open:rotate-180 text-yellow-300">
                <svg
                  fill="none"
                  height="24"
                  shape-rendering="geometricPrecision"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  viewBox="0 0 24 24"
                  width="24"
                >
                  <path d="M6 9l6 6 6-6"></path>
                </svg>
              </span>
            </summary>
            <p
              class="group-open:animate-fadeIn mt-3 text-neutral-600 ml-3 text-justify"
            >
              {{ item.answer }}
            </p>
          </details>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

const faqItems = ref([
  {
    question: "Is this platform free?",
    answer: "Yes, the platform is 100% free for any user to use.",
  },
  {
    question: "What types of documents can I upload to this platform?",
    answer:
      "Users can upload invoices, warranties, contracts, and any other documents relevant to the products and services they have purchased.",
  },
  {
    question: "Is the platform secure for storing my documents?",
    answer:
      "Yes, all files are stored in a secure environment following the best security practices.",
  },
  {
    question: "How can I upload a document to the platform?",
    answer:
      "You can upload documents by selecting the “Add Warranty/Invoice” button in your account and choosing the desired file from your device. We support common formats such as PDF, JPG, PNG, and others.",
  },
  {
    question: "Can I access my documents from any device?",
    answer:
      "Yes, the platform is accessible from any device with an internet connection.",
  },
  {
    question: "What happens if I lose access to my account?",
    answer:
      "If you forget your password or have trouble accessing your account, you can use the 'Password Recovery' option to reset your password and regain access to your account.",
  },
  {
    question: "How long are documents stored on the platform?",
    answer:
      "Documents are securely stored for an unlimited period, as long as your account remains active. If you choose to close your account, you will have the option to download or save your documents before they are deleted.",
  },
  {
    question: "How can I delete a document from my account?",
    answer:
      "Documents are securely stored for an unlimited period, as long as your account remains active. If you choose to close your account, you will have the option to download or save your documents before they are deleted.You can delete a document from your account by clicking the “Delete” button. We recommend making sure you no longer need the document before deleting it.",
  },
  {
    question: "How can I update an already uploaded document?",
    answer:
      "You can edit a document or its details from your account by clicking the “Edit” button.",
  },
  {
    question:
      "What should I do if the uploaded document can't be viewed or is corrupted?",
    answer:
      "If you’re having trouble viewing a document, we recommend checking the file format. If the issue persists, please contact the support team for assistance.",
  },
]);
</script>
