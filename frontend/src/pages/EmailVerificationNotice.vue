<script setup>
import { onMounted } from "vue";
import { useAuthStore } from "../store/authStore";

const authStore = useAuthStore();

function resendVerification() {
  authStore.resendVerificationEmail();
}

onMounted(() => {
  authStore.resendVerificationEmail();
});
</script>

<template>
  <main class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="flex items-center justify-center py-4">
      <div class="email-verification-notice bg-white shadow rounded-lg p-8 text-center max-w-md">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">
          Verify your email address.
        </h1>
        <p class="text-gray-700 mb-6">
          We have sent you a verification link. Please check your inbox.
        </p>

        <button
          :disabled="authStore.countdown > 0"
          @click="resendVerification"
          class="w-full py-2 px-4 font-semibold rounded-lg text-white transition duration-300"
          :class="authStore.countdown > 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-yellow-400 hover:bg-yellow-500'"
        >
          <span v-if="authStore.countdown === 0">
            Resend verification email
          </span>
          <span v-else>
            Resend available in {{ authStore.countdown }}s
          </span>
        </button>

        <p v-if="authStore.message" class="text-green-600 mt-4">
          {{ authStore.message }}
        </p>
      </div>
    </div>
  </main>
</template>
