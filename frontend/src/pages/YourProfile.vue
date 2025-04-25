<script setup>
import { onMounted, ref, computed } from "vue";
import useUserStore from "../store/user";
import axiosClient from "../axios";
import router from "../router";

const data_info = ref({
  name: "",
  email: "",
});

const data_password = ref({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const data_destroy = ref({
  password: "",
});

const errors_info = ref({
  name: [],
  email: [],
});

const errors_password = ref({
  current_password: [],
  password: [],
  password_confirmation: [],
});

const errors_destroy = ref({
  password: [],
});

const userStore = useUserStore();

const user = computed(() => userStore.user);

function submit_info() {
  const formData = new FormData();
  formData.append("name", data_info.value.name);
  formData.append("email", data_info.value.email);
  formData.append("_method", "PUT");

  axiosClient
    .post("profile", formData)
    .then(() => {
      router.push({ name: "Home" });
    })
    .catch((error) => {
      if (error.response) {
        errors_info.value = error.response.data.errors;
      } else {
        console.log("Error without response:", error);
      }
    });
}

function submit_password() {
  const formData = new FormData();
  formData.append("current_password", data_password.value.current_password);
  formData.append("password", data_password.value.password);
  formData.append(
    "password_confirmation",
    data_password.value.password_confirmation
  );
  formData.append("_method", "PUT");

  axiosClient
    .post("password", formData)
    .then(() => {
      router.push({ name: "Home" });
    })
    .catch((error) => {
      if (error.response) {
        errors_password.value = error.response.data.errors;
      } else {
        console.log("Error without response:", error);
      }
    });
}

function submit_delete() {
  if (!confirm("Are you sure you want to delete your account?")) {
    return;
  }

  const formData = new FormData();
  formData.append("password", data_destroy.value.password);
  axiosClient
    .post("profile", formData)
    .then((response) => {
      if (response.data.redirect_to_login) {
        router.push({ name: "Login" });
      } else {
        alert(response.data.message);
      }
    })
    .catch((error) => {
      if (error.response) {
        errors_destroy.value = error.response.data.errors;
      } else {
        console.log("Error without response:", error);
      }
    });
}

onMounted(() => {
  data_info.value.name = user.value.name;
  data_info.value.email = user.value.email;
});
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
    </div>
  </header>
  <main>
    <div class="px-4 py-6 sm:px-6 lg:px-8">
      <form
        @submit.prevent="submit_info"
        class="space-y-4 max-w-lg mx-auto border-2 border-neutral-300 bg-white rounded-xl p-4 hover:border-yellow-300"
      >
        <div class="text-neutral-700 font-bold text-2xl">Information</div>
        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Name</label
          >
          <input
            type="text"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_info.name"
          />
          <p class="text-sm text-red-600">
            {{ errors_info && errors_info.name ? errors_info.name[0] : "" }}
          </p>
        </div>

        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Email</label
          >
          <input
            type="email"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_info.email"
          />
          <p class="text-sm text-red-600">
            {{ errors_info && errors_info.email ? errors_info.email[0] : "" }}
          </p>
        </div>

        <button
          type="submit"
          class="text-gray-900 border-2 cursor-pointer border-yellow-300 bg-yellow-300 hover:bg-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
        >
          <div class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z"
              />
            </svg>
            Save
          </div>
        </button>
      </form>
      <div class="py-4" />
      <form
        @submit.prevent="submit_password"
        class="space-y-4 max-w-lg mx-auto border-2 border-neutral-300 bg-white rounded-xl p-4 hover:border-yellow-300"
      >
        <div class="text-neutral-700 font-bold text-2xl">Update Password</div>
        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Current password</label
          >
          <input
            type="password"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_password.current_password"
          />
          <p class="text-sm text-red-600">
            {{
              errors_password && errors_password.current_password
                ? errors_password.current_password[0]
                : ""
            }}
          </p>
        </div>

        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >New password</label
          >
          <input
            type="password"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_password.password"
          />
          <p class="text-sm text-red-600">
            {{
              errors_password && errors_password.password
                ? errors_password.password[0]
                : ""
            }}
          </p>
        </div>

        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Confirm password</label
          >
          <input
            type="password"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_password.password_confirmation"
          />
          <p class="text-sm text-red-600">
            {{
              errors_password && errors_password.password_confirmation
                ? errors_password.password_confirmation[0]
                : ""
            }}
          </p>
        </div>

        <button
          type="submit"
          class="text-gray-900 border-2 cursor-pointer border-yellow-300 bg-yellow-300 hover:bg-white font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
        >
          <div class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M21 7v12q0 .825-.587 1.413T19 21H5q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h12zm-9 11q1.25 0 2.125-.875T15 15t-.875-2.125T12 12t-2.125.875T9 15t.875 2.125T12 18m-6-8h9V6H6z"
              />
            </svg>
            Save
          </div>
        </button>
      </form>

      <div class="py-4" />
      <form
        @submit.prevent="submit_delete"
        class="space-y-4 max-w-lg mx-auto border-2 border-neutral-300 bg-white rounded-xl p-4 hover:border-yellow-300"
      >
        <div class="text-neutral-700 font-bold text-2xl">Delete Account</div>

        <div class="text-neutral-700 text-sm">
          Once your account is deleted, all of its resources and data will be
          permanently deleted. Before deleting your account, please download any
          data or information that you wish to retain.
        </div>

        <div class="mb-5">
          <label for="text" class="block mb-2 text-sm font-medium text-gray-900"
            >Password</label
          >
          <input
            type="password"
            id="text"
            class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg hover:border-neutral-400 block w-full p-2.5"
            v-model="data_destroy.password"
          />
          <p class="text-sm text-red-600">
            {{
              errors_destroy && errors_destroy.password
                ? errors_destroy.password[0]
                : ""
            }}
          </p>
        </div>

        <button
          type="submit"
          class="text-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 mb-2"
          :class="{
            'bg-red-400 hover:bg-red-500 focus:ring-[#F7BE38]/50':
              data_destroy.password,
            'bg-gray-300 cursor-not-allowed': !data_destroy.password,
          }"
          :disabled="!data_destroy.password"
        >
          <div class="flex items-center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
              class="mr-2"
            >
              <path
                fill="currentColor"
                d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"
              />
            </svg>
            Delete Account
          </div>
        </button>
      </form>
    </div>
  </main>
</template>

<style scoped></style>
