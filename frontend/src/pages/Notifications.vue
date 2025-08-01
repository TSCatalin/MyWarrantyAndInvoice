<script setup>
import { onMounted} from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/ro";

import { useNotificationStore } from '../store/notificationStore'

const notificationStore = useNotificationStore();

onMounted(() => {
  notificationStore.fetchAll();
});

dayjs.extend(relativeTime);
dayjs.locale("uk");

const timeFromNow = (date) => {
  return dayjs(date).fromNow();
};

const truncateProductName = (name) => {
  return name.length > 40 ? name.substring(0, 40) + "..." : name;
};
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
    </div>
  </header>
  <main>
    <div v-if="notificationStore.loading" class="px-5 py-4 flex justify-center">
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
    <div v-else class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-4">
      <div class="max-w-7xl mx-auto">
        <div class="py-6 max-w-4xl mx-auto space-y-6">
          <RouterLink
            v-for="ah in notificationStore.notifications"
            :key="ah.id"
            :to="{ name: 'Notifications_Show', params: { id: ah.id } }"
            class="relative block bg-white border-l-4 rounded-xl shadow-sm transition hover:shadow-md hover:border-yellow-500"
            :class="
              ah.read_at === null ? 'border-yellow-300' : 'border-gray-200'
            "
          >
            <div class="flex items-start gap-4 p-6">
              <div class="mt-1">
                <div class="bg-yellow-300 p-2 rounded-full shadow-md">
                  <svg
                    class="w-5 h-5 text-white"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M15 8.38V17H3V5h8.62c-.073-.322-.12-.655-.12-1s.047-.678.12-1H3a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V8.38c-.322.073-.655.12-1 .12s-.678-.047-1-.12M16 1a3 3 0 100 6 3 3 0 000-6"
                    />
                  </svg>
                </div>
              </div>

              <div class="flex-1 min-w-0">
                <h3 class="text-lg font-semibold text-gray-800 mb-1">
                  {{ ah.data.title }}
                </h3>
                <p class="text-gray-600 text-sm leading-snug truncate">
                  {{ truncateProductName(ah.data.message) }}
                </p>
                <p class="text-xs text-gray-400 mt-2">
                  {{ timeFromNow(ah.created_at) }}
                </p>
              </div>

              <div v-if="ah.read_at === null" class="mt-1">
              <span class="block w-2 h-2 bg-yellow-300 rounded-full"></span>
            </div>
            </div>
          </RouterLink>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped></style>
