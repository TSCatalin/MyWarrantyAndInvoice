<script setup>
import { onMounted, defineComponent, h } from "vue";
import { useHistoryStore } from "../store/historyStore";

const historyStore = useHistoryStore();

onMounted(() => {
  historyStore.fetchAll();
});

const getActionIcon = (type) => {
  switch (type) {
    case "CREATE":
      return defineComponent({
        render() {
          return h("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            fill: "currentColor",
            viewBox: "0 0 24 24",
            innerHTML: `<path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5v2H5v14h14v-5z"/><path d="M21 7h-4V3h-2v4h-4v2h4v4h2V9h4z"/>`,
          });
        },
      });
    case "EDIT":
      return defineComponent({
        render() {
          return h("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            fill: "currentColor",
            viewBox: "0 0 24 24",
            innerHTML: `<path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM5.92 19H5v-.92l9.06-9.06l.92.92zM20.71 5.63l-2.34-2.34c-.2-.2-.45-.29-.71-.29s-.51.1-.7.29l-1.83 1.83l3.75 3.75l1.83-1.83a.996.996 0 0 0 0-1.41"/>`,
          });
        },
      });
    case "DELETE":
      return defineComponent({
        render() {
          return h("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            fill: "currentColor",
            viewBox: "0 0 24 24",
            innerHTML: `<path d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zM17 6H7v13h10zM9 17h2V8H9zm4 0h2V8h-2z"/>`,
          });
        },
      });
    default:
      return defineComponent({
        render() {
          return h("svg", {
            xmlns: "http://www.w3.org/2000/svg",
            fill: "currentColor",
            viewBox: "0 0 24 24",
            innerHTML: `<circle cx="12" cy="12" r="10" />`,
          });
        },
      });
  }
};
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold text-gray-900">Action History</h1>
    </div>
  </header>
  <main>
    <div v-if="historyStore.loading" class="px-5 py-4 flex justify-center">
      <button
        disabled
        type="button"
        class="py-10 px-10 me-2 text-2xl font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-yellow-400 focus:z-10 focus:ring-2 focus:ring-yellow-300 focus:text-yellow-500 inline-flex items-center"
      >
        <div role="status">
          <svg
            aria-hidden="true"
            class="inline w-8 h-8 me-2 text-gray-200 animate-spin fill-yellow-300"
            viewBox="0 0 100 101"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
              fill="currentColor"
            />
            <path
              d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
              fill="currentFill"
            />
          </svg>
        </div>
        Loading...
      </button>
    </div>
    <div v-else class="max-w-7xl mx-auto">
      <div class="px-4 py-6 max-w-5xl mx-auto space-y-4">
        <div
          v-for="ah in historyStore.action_history.data"
          :key="ah.id"
          class="relative flex items-start gap-4 p-5 rounded-xl border-l-4 shadow-sm transition hover:shadow-md bg-white border-yellow-300"
        >
          <div class="mt-1">
            <div
              :class="{
                'bg-green-300': ah.type_action === 'CREATE',
                'bg-yellow-300': ah.type_action === 'EDIT',
                'bg-red-300': ah.type_action === 'DELETE',
              }"
              class="rounded-full p-2 shadow-md"
            >
              <component
                :is="getActionIcon(ah.type_action)"
                class="w-5 h-5 text-white"
              />
            </div>
          </div>

          <div class="flex-1 min-w-0">
            <div
              class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-1"
            >
              <span class="text-sm text-gray-500">{{ ah.date_action }}</span>
              <span
                class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 rounded-full"
                :class="{
                  'bg-green-100 text-green-700': ah.type_action === 'CREATE',
                  'bg-yellow-100 text-yellow-700': ah.type_action === 'EDIT',
                  'bg-red-100 text-red-700': ah.type_action === 'DELETE',
                }"
              >
                <component
                  :is="getActionIcon(ah.type_action)"
                  class="w-4 h-4"
                />
                {{ ah.type_action }}
              </span>
            </div>

            <p class="text-sm text-gray-700 truncate">
              {{ ah.info_action }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
