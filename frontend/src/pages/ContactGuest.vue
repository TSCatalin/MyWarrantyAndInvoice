<script setup>
import { ref } from "vue";
import { useAuthStore } from "../store/authStore";
import router from "../router";

const authStore = useAuthStore();

const errors = ref("");
const data = ref({
  first_name: "",
  last_name: "",
  email: "",
  message: "",
});
const messageSuccess = ref("");

async function submit() {
  errors.value = {};

  const result = await authStore.contactForm({ ...data.value });

  if (result.success) {
    messageSuccess.value = "Message sent successfully!";
    setTimeout(() => {
      router.push({ name: "Home" });
    }, 5000);
  } else {
    errors.value = result.errors;
  }
}
</script>

<template>
  <div class="bg-white px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <div class="pt-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-24 pb-14">
        <div
          class="text-black text-5xl font-bold underline underline-offset-4 decoration-yellow-300"
        >
          Contact Us
        </div>
        <p class="mt-6 text-lg/8 text-gray-600">
          Do you have questions, suggestions, or have you encountered a problem?
          We're here to help!e.
        </p>
      </div>
    </div>
    <div v-if="messageSuccess" class="pb-12">
      <div
        class="bg-green-50 mx-auto text-center border max-w-xl border-green-400 text-green-700 px-4 py-3 rounded-md flex items-center justify-center text-lg"
      >
        <svg
          class="fill-current w-6 h-6 mr-2"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
        >
          <path d="M10 15l-3.5-3.5 1.41-1.41L10 12.17l4.59-4.59L16 9l-6 6z" />
        </svg>
        <span>{{ messageSuccess }}</span>
      </div>
    </div>

    <form
      @submit.prevent="submit"
      class="space-y-4 max-w-lg mx-auto bg-white pb-24"
      v-if="!messageSuccess"
    >
      <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
        <div>
          <label
            for="first-name"
            class="block text-sm/6 font-semibold text-gray-900"
            >First name</label
          >
          <div class="mt-2.5">
            <input
              type="text"
              id="first_name"
              class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
              v-model="data.first_name"
            />
          </div>
          <p class="text-sm text-red-600">
            {{ errors && errors.first_name ? errors.first_name[0] : "" }}
          </p>
        </div>
        <div>
          <label
            for="last-name"
            class="block text-sm/6 font-semibold text-gray-900"
            >Last name</label
          >
          <div class="mt-2.5">
            <input
              type="text"
              id="last_name"
              class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
              v-model="data.last_name"
            />
          </div>
          <p class="text-sm text-red-600">
            {{ errors && errors.last_name ? errors.last_name[0] : "" }}
          </p>
        </div>
        <div class="sm:col-span-2">
          <label for="email" class="block text-sm/6 font-semibold text-gray-900"
            >Email</label
          >
          <div class="mt-2.5">
            <input
              type="email"
              id="email"
              class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
              v-model="data.email"
            />
          </div>
          <p class="text-sm text-red-600">
            {{ errors && errors.email ? errors.email[0] : "" }}
          </p>
        </div>
        <div class="sm:col-span-2">
          <label
            for="message"
            class="block text-sm/6 font-semibold text-gray-900"
            >Message</label
          >
          <div class="mt-2.5">
            <textarea
              id="message"
              rows="4"
              class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline--yellow-300"
              v-model="data.message"
            />
          </div>
          <p class="text-sm text-red-600">
            {{ errors && errors.message ? errors.message[0] : "" }}
          </p>
        </div>
      </div>
      <div class="mt-10">
        <button
          type="submit"
          class="block w-full rounded-md bg-yellow-300 px-3.5 py-2.5 text-center text-base font-semibold text-black shadow-xs hover:bg-yellow-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
          Submit
        </button>
      </div>
    </form>
  </div>
</template>
