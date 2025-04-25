<script setup>
import axiosClient from "../axios";
import { ref } from "vue";
import router from "../router";
import SignupImage from "../components/SignupImage.vue";

const data = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const errors = ref({
  name: [],
  email: [],
  password: [],
});

function submit() {
  axiosClient.get("/sanctum/csrf-cookie").then((response) => {
    axiosClient
      .post("/register", data.value)
      .then((response) => {
        router.push({ name: "Home" });
      })
      .catch((error) => {
        if (error.response) {
          console.log(error.response);
          errors.value = error.response.data.errors;
        } else {
          console.log("Error without response:", error);
        }
      });
  });
}
</script>

<template>
  <div>
    <div class="flex flex-row min-h-screen">
      <div class="hidden md:flex w-9/12 bg-white items-center justify-center">
        <SignupImage />
      </div>

      <div
        class="w-full flex flex-col justify-center items-center pt-6 sm:pt-0 bg-white px-8"
      >
        
        <h2
          class="mt-6 text-center text-3xl/9 font-bold tracking-tight text-gray-900 py-8"
        >
          Create new Account
        </h2>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
          <form @submit.prevent="submit" class="space-y-4">
            <div>
              <label
                for="name"
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
                    d="M480-480q-60 0-102-42t-42-102q0-60 42-102t102-42q60 0 102 42t42 102q0 60-42 102t-102 42ZM192-192v-96q0-23 12.5-43.5T239-366q55-32 116.29-49 61.29-17 124.5-17t124.71 17Q666-398 721-366q22 13 34.5 34t12.5 44v96H192Zm72-72h432v-24q0-5.18-3.03-9.41-3.02-4.24-7.97-6.59-46-28-98-42t-107-14q-55 0-107 14t-98 42q-5 4-8 7.72-3 3.73-3 8.28v24Zm216.21-288Q510-552 531-573.21t21-51Q552-654 530.79-675t-51-21Q450-696 429-674.79t-21 51Q408-594 429.21-573t51 21Zm-.21-72Zm0 360Z"
                  />
                </svg>
                Your Full Name
              </label>
              <div class="mt-2">
                <input
                  name="name"
                  id="name"
                  v-model="data.name"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
                />
              </div>
              <p class="text-sm text-red-600">
                {{ errors.name ? errors.name[0] : "" }}
              </p>
            </div>
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
                Email address</label
              >
              <div class="mt-2">
                <input
                  type="email"
                  name="email"
                  id="email"
                  autocomplete="email"
                  v-model="data.email"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
                />
              </div>
              <p class="text-sm text-red-600">
                {{ errors.email ? errors.email[0] : "" }}
              </p>
            </div>

            <div>
              <div class="flex items-center justify-between">
                <label
                  for="password"
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
                      d="M288-384q-40 0-68-28t-28-68q0-40 28-68t68-28q40 0 68 28t28 68q0 40-28 68t-68 28Zm0 144q-100 0-170-70T48-480q0-100 70-170t170-70q65 0 120 32.5t88 87.5h344l120 120-180 168-84-60-72 60-96-72h-20q-24 68-85.5 106T288-240Zm0-72q63 0 111-40.5T454-456h98l70 52 71-59 81 58 82-76-46-47H449q-19-53-62.5-86.5T288-648q-70 0-119 49t-49 119q0 70 49 119t119 49Z"
                    />
                  </svg>
                  Password</label
                >
              </div>
              <div class="mt-2">
                <input
                  type="password"
                  name="password"
                  id="password"
                  v-model="data.password"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
                />
              </div>
              <p class="text-sm text-red-600">
                {{ errors.password ? errors.password[0] : "" }}
              </p>
            </div>

            <div>
              <div class="flex items-center justify-between">
                <label
                  for="passwordConfirmation"
                  class="text-base/6 font-medium text-gray-900 flex items-center"
                  >Repeat Password</label
                >
              </div>
              <div class="mt-2">
                <input
                  type="password"
                  name="password"
                  id="passwordConfirmation"
                  v-model="data.password_confirmation"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
                />
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-yellow-300 px-3 py-1.5 text-base font-semibold text-black shadow-sm hover:bg-yellow-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500"
              >
                Create an Account
              </button>
            </div>
          </form>
          <p class="mt-10 text-center text-sm/6 text-gray-500 mb-24">
            Already have an account?
            {{ " " }}
            <RouterLink
              :to="{ name: 'Login' }"
              class="font-semibold text-yellow-400 hover:text-yellow-300"
            >
              Login from here
            </RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
