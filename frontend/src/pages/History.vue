<script setup>
import axiosClient from "../axios";
import { onMounted, ref, watch } from "vue";
import router from "../router";

const action_history = ref([]);

onMounted(() => {
  axiosClient
    .get("/api/action_history")
    .then((response) => {
      console.log(response.data);
      action_history.value = response.data.data;
    })
    .catch((error) => {
      console.error("Error fetching Action History data:", error);
    });
});
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold text-gray-900">Action History</h1>
    </div>
  </header>
  <main>
    <div class="max-w-7xl mx-auto">
      <div class="px-2 py-6 md:px-6 lg:px-10">
        <div
          v-for="ah in action_history"
          :key="ah.id"
          class="flex flex-wrap md:flex-nowrap items-center md:items-center justify-between gap-2 bg-white border border-gray-200 hover:border-yellow-300 rounded-md px-4 py-2 mb-2 shadow-sm hover:shadow-md transition"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="1.2em"
            height="1.2em"
            viewBox="0 0 24 24"
            class="text-yellow-300"
          >
            <path
              fill="none"
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 12a4 4 0 1 0 8 0a4 4 0 1 0-8 0"
            />
          </svg>
          <div class="text-sm text-gray-500 min-w-[120px]">
            {{ ah.date_action }}
          </div>

          <div
            class="text-sm font-semibold capitalize px-2 py-1 rounded-full text-center flex items-center gap-2"
            :class="{
              'bg-green-100 text-green-700': ah.type_action === 'CREATE',
              'bg-yellow-100 text-yellow-700': ah.type_action === 'EDIT',
              'bg-red-100 text-red-700': ah.type_action === 'DELETE',
            }"
            style="min-width: 90px"
          >
            <svg
              v-if="ah.type_action === 'CREATE'"
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5v2H5v14h14v-5z"
              />
              <path fill="currentColor" d="M21 7h-4V3h-2v4h-4v2h4v4h2V9h4z" />
            </svg>

            <svg
              v-else-if="ah.type_action === 'EDIT'"
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM5.92 19H5v-.92l9.06-9.06l.92.92zM20.71 5.63l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83a.996.996 0 0 0 0-1.41"
              />
            </svg>

            <svg
              v-else-if="ah.type_action === 'DELETE'"
              xmlns="http://www.w3.org/2000/svg"
              width="1.2em"
              height="1.2em"
              viewBox="0 0 24 24"
            >
              <path
                fill="currentColor"
                d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2zM7 6v13z"
              />
            </svg>

            {{ ah.type_action }}
          </div>

          <div
            class="text-sm text-gray-700 flex-1 truncate md:whitespace-nowrap"
          >
            {{ ah.info_action }}
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
