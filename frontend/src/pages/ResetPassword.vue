<script setup>
import { onMounted, ref, computed } from "vue";
import { useAuthStore } from "../store/authStore";
import { useRoute } from "vue-router";
import router from "../router";

const authStore = useAuthStore();

const errors = ref("");
const route = useRoute();

const data = ref({
  token: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const showPassword = ref(false);
const showPasswordConf = ref(false);

const message = ref("");
const messageSuccess = ref("");

async function submit() {
  errors.value = {};

  const result = await authStore.resetPassword({ ...data.value });

  if (result.success) {
    messageSuccess.value =
      "Your password has been successfully reset. You will be redirected to the homepage.";
    setTimeout(() => {
      router.push({ name: "Home" });
    }, 5000);
  } else {
    errors.value = result.errors;

    if (result.errors?.email?.[0]) {
      message.value = result.errors.email[0];
    } else if (result.errors?.token?.[0]) {
      message.value = result.errors.token[0];
    } else {
      message.value =
        "Your session is invalid or has expired. You are being redirected.";
    }

    setTimeout(() => {
      router.push({ name: "HomeGuest" });
    }, 5000);
  }
}

onMounted(() => {
  const token = route.fullPath.split("/password-reset/")[1]?.split("?")[0];
  const email = route.query.email;

  data.value.token = token || "";
  data.value.email = email || "";
});

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

const togglePasswordConf = () => {
  showPasswordConf.value = !showPasswordConf.value;
};
</script>

<template>
  <div class="bg-white px-6 lg:px-8">
    <div class="mx-auto max-w-2xl text-center">
      <div class="pt-8 px-4 mx-auto max-w-screen-xl text-center lg:pt-24 pb-14">
        <div
          class="text-black text-5xl font-bold underline underline-offset-4 decoration-yellow-300"
        >
          Reset password
        </div>
      </div>
    </div>
    <div
      v-if="message"
      class="alert alert-warning flex items-center justify-center text-red-500 mb-6"
    >
      {{ message }}
    </div>
    <div
      v-if="messageSuccess"
      class="alert alert-warning flex items-center justify-center text-green-300 mb-6"
    >
      {{ messageSuccess }}
    </div>
    <form
      @submit.prevent="submit"
      class="space-y-4 max-w-lg mx-auto bg-white pb-24"
    >
      <div class="mb-5">
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
        <input
          type="email"
          id="email"
          class="block w-full rounded-md mt-2 bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
          v-model="data.email"
        />
        <p class="text-sm text-red-600">
          {{ errors && errors.email ? errors.email[0] : "" }}
        </p>
      </div>

      <div class="mb-5 relative">
        <label
          for="password"
          class="text-base/6 font-medium text-gray-900 flex items-center mb-1"
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
              d="M12 17a2 2 0 0 1-2-2c0-1.11.89-2 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2m6 3V10H6v10zm0-12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10c0-1.11.89-2 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3"
            />
          </svg>
          New password
        </label>

        <input
          :type="showPassword ? 'text' : 'password'"
          id="password"
          class="block w-full rounded-md mt-2 bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
          v-model="data.password"
        />

        <button
          type="button"
          class="absolute right-3 top-10 text-gray-500 hover:text-gray-700"
          @click="togglePassword"
        >
          <svg
            v-if="!showPassword"
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.967 9.967 0 012.042-3.368M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8"
            />
          </svg>
        </button>

        <p class="text-sm text-red-600 mt-1">
          {{ errors && errors.password ? errors.password[0] : "" }}
        </p>
      </div>

      <div class="mb-5 relative">
        <label
          for="confirm-password"
          class="text-base/6 font-medium text-gray-900 flex items-center"
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
              d="M12 17a2 2 0 0 1-2-2c0-1.11.89-2 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2m6 3V10H6v10zm0-12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V10c0-1.11.89-2 2-2h1V6a5 5 0 0 1 5-5a5 5 0 0 1 5 5v2zm-6-5a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3"
            />
          </svg>
          Confirm password
        </label>
        <input
          :type="showPasswordConf ? 'text' : 'password'"
          id="passwordConf"
          class="block w-full rounded-md mt-2 bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
          v-model="data.password_confirmation"
        />

        <button
          type="button"
          class="absolute right-3 top-10 text-gray-500 hover:text-gray-700"
          @click="togglePasswordConf"
        >
          <svg
            v-if="!showPasswordConf"
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
            />
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M2.458 12C3.732 7.943 7.522 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"
            />
          </svg>
          <svg
            v-else
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.967 9.967 0 012.042-3.368M9.88 9.88a3 3 0 104.24 4.24M6.1 6.1l11.8 11.8"
            />
          </svg>
        </button>
        <p class="text-sm text-red-600">
          {{
            errors && errors.password_confirmation
              ? errors.password_confirmation[0]
              : ""
          }}
        </p>
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
  </div>
</template>
