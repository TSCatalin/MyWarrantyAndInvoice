<script setup>
import { onMounted } from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/ro";

import { useNotificationStore } from "../store/notificationStore";
import { useRoute, useRouter } from "vue-router";

dayjs.extend(relativeTime);
dayjs.locale("uk");

const notificationStore = useNotificationStore();
const route = useRoute();
const router = useRouter();

onMounted(async () => {
  try {
    const notif = await notificationStore.fetchById(route.params.id);

    if (notif && notif.read_at === null) {
      await notificationStore.markAsRead(route.params.id);
    }
  } catch (error) {
    if (error.message === "NOT_FOUND") {
      router.push("/not-found");
    }
  }
});

const timeFromNow = (date) => {
  return dayjs(date).fromNow();
};
</script>


<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-2xl font-bold text-gray-900">Notifications Show</h1>
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
    <div v-else-if="notificationStore.notification" class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
  <div class="relative bg-white border-l-4 border-yellow-300 shadow-lg rounded-xl p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 mt-2 pl-10">
      {{ notificationStore.notification.data.title }}
    </h2>
    <p class="text-lg text-gray-700 pl-10 pr-4 mb-4 leading-relaxed">
      {{ notificationStore.notification.data.message }}
    </p>
    <RouterLink
      :to="notificationStore.notification.data.link"
      class="inline-block ml-10 text-yellow-300 font-medium text-base hover:underline transition duration-200"
    >
      Open the link &rarr;
    </RouterLink>
    <div class="text-sm text-gray-500 mt-6 ml-10">
      {{ timeFromNow(notificationStore.notification.created_at) }}
    </div>
  </div>
</div>
  </main>
</template>

<style scoped></style>
