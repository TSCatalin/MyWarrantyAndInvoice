<script setup>
import { useAuthStore } from "../store/authStore";
import { ref } from "vue";
import router from "../router";

const authStore = useAuthStore();

const data = ref({
  email: "",
});

const message = ref("");
const errorMessage = ref("");

const submit = async () => {
  const result = await authStore.forgotPassword(data.value);

  if (result.success) {
    message.value = result.message;
    setTimeout(() => {
      router.push({ name: "HomeGuest" });
    }, 5000);
  } else {
    errorMessage.value = result.message;
  }
};
</script>

<template>
  <div class="bg-white px-6 lg:px-8 pb-14">
    <div class="mx-auto max-w-2xl text-center">
      <div class="pt-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-24 pb-14">
        <div
          class="text-black text-5xl font-bold underline underline-offset-4 decoration-yellow-300"
        >
          Forgot your password?
        </div>
        <p class="mt-4 text-lg/8 text-gray-600">
          No problem. Just let us know your email address and we will email you
          a password reset link that will allow to choose a new one.
        </p>
      </div>
      <div v-if="errorMessage" class="mt-2 mb-4 py-2 px-3 rounded text-red-500">
        {{ errorMessage }}
      </div>
    </div>
    <form @submit.prevent="submit" class="mx-auto max-w-md pb-2">
      <div>
        <label
          for="email"
          class="text-base/6 font-medium text-gray-900 flex items-center"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="20px"
            viewBox="0 -960 960 960"
            width="20px"
            fill="#000000"
            class="mr-2"
          >
            <path
              d="M168-192q-29.7 0-50.85-21.16Q96-234.32 96-264.04v-432.24Q96-726 117.15-747T168-768h624q29.7 0 50.85 21.16Q864-725.68 864-695.96v432.24Q864-234 842.85-213T792-192H168Zm312-240L168-611v347h624v-347L480-432Zm0-85 312-179H168l312 179Zm-312-94v-85 432-347Z"
            />
          </svg>
          Email address
        </label>

        <div class="mt-2">
          <input
            type="email"
            name="email"
            id="email"
            autocomplete="email"
            required=""
            v-model="data.email"
            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
          />
        </div>
      </div>
      <div class="mt-10">
        <button
          type="submit"
          class="flex w-full justify-center rounded-md bg-yellow-300 px-3 py-1.5 text-base font-semibold text-black hover:bg-yellow-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500"
        >
          Submit
        </button>
      </div>
    </form>
    <div class="mx-auto max-w-md pb-4 flex items-center justify-center">
      <p v-if="message" class="text-green-600 mt-4">
        {{ message }}
      </p>
    </div>
  </div>
</template>
