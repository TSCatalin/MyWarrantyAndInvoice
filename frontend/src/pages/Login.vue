<script setup>
import axiosClient from "../axios";
import { ref, onMounted } from "vue";
import router from "../router";
import LoginImage from "../components/loginImage.vue";

const data = ref({
  email: "",
  password: "",
});

const errorMessage = ref("");

function submit() {
  axiosClient.get("/sanctum/csrf-cookie").then((response) => {
    axiosClient
      .post("/login", data.value)
      .then((response) => {
        axiosClient
          .get("/api/warranty/updateStatusWarranty")
          .then((response) => {
            console.log(response.data);
          })
          .catch((error) => {
            console.error("Error", error);
          });
        router.push({ name: "Home" });
      })
      .catch((error) => {
        console.log(error.response);
        errorMessage.value = error.response.data.message;
      });
  });
}

onMounted(() => {
  axiosClient.get("/api/user")
    .then(response => {
      router.push({ name: 'Home' });
    })
    .catch(error => {
      console.log("The user is not authenticated:", error);
    });
});

</script>

<template>
  <div>
    <div class="flex flex-row min-h-screen">
    <div class="hidden md:flex w-9/12 bg-white items-center justify-center">
      <LoginImage/>
      <div></div></div>
      <div
        class="w-full flex flex-col justify-center items-center pt-6 sm:pt-0 bg-white px-8"
      >
        <h2
          class="mt-6 text-center text-3xl/9 font-bold tracking-tight text-gray-900 py-8"
        >
          Sign in to your account
        </h2>

        <div
          v-if="errorMessage"
          class="mt-4 py-2 px-3 rounded text-white bg-red-400"
        >
          {{ errorMessage }}
        </div>

        <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
          <form @submit.prevent="submit" class="space-y-4">
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

            <div class="py-6">
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
                  Password
                </label>
              </div>
              <div class="mt-2">
                <input
                  type="password"
                  name="password"
                  id="password"
                  autocomplete="current-password"
                  required=""
                  v-model="data.password"
                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-yellow-300 sm:text-sm/6"
                />
              </div>
            </div>

            <div>
              <button
                type="submit"
                class="flex w-full justify-center rounded-md bg-yellow-300 px-3 py-1.5 text-base font-semibold text-black hover:bg-yellow-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-yellow-500"
              >
                Sign in
              </button>
            </div>
          </form>

          <p class="mt-10 mb-28 text-center text-sm/6 text-gray-500">
            Not a member?
            {{ " " }}
            <RouterLink
              :to="{ name: 'Signup' }"
              class="font-semibold text-yellow-400 hover:text-yellow-300"
            >
              Create an account
            </RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
