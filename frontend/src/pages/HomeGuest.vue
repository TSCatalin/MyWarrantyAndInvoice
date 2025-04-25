<script setup>
import { ref } from "vue";

const faqItems = ref([
  {
    question: "Is this platform free?",
    answer: "Yes, the platform is 100% free for any user to use.",
  },
  {
    question: "What types of documents can I upload to this platform?",
    answer:
      "Users can upload invoices, warranties, contracts, and any other documents relevant to the products and services they have purchased.",
  },
  {
    question: "Is the platform secure for storing my documents?",
    answer:
      "Yes, all files are stored in a secure environment following the best security practices.",
  },
  {
    question: "Can I access my documents from any device?",
    answer:
      "Yes, the platform is accessible from any device with an internet connection.",
  },
  {
    question: "What happens if I lose access to my account?",
    answer:
      "f you forget your password or have trouble accessing your account, you can use the 'Password Recovery' option to reset your password and regain access to your account.",
  },
]);
</script>

<template>
  <GuestLayout>
    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-24">
        <h1
          class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl"
        >
          Store and manage your warranties and invoices in one place.
        </h1>
        <p
          class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48"
        >
          Quickly access essential information about your products and save
          time.
        </p>
        <div
          class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0"
        >
          <RouterLink
            :to="{ name: 'Signup' }"
            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-black rounded-lg bg-yellow-300 hover:bg-yellow-400 focus:ring-4 focus:ring-blue-300"
          >
            Get started
            <svg
              class="w-3.5 h-3.5 ms-2 rtl:rotate-180"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 14 10"
            >
              <path
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M1 5h12m0 0L9 1m4 4L9 9"
              />
            </svg>
          </RouterLink>
          <RouterLink
            :to="{ name: 'AboutGuest' }"
            class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-50 hover:text-yellow-300 focus:z-10 focus:ring-4 focus:ring-gray-100"
          >
            Learn more
          </RouterLink>
        </div>
      </div>
    </section>

    <div class="bg-white py-4 sm:py-6 px-4 lg:px-8">
      <div class="rounded-lg shadow-lg mx-auto max-w-screen-xl p-8">
        <div class="mx-auto max-w-2xl lg:text-center">
          <p
            class="mt-2 text-4xl font-bold tracking-tight leading-none text-gray-900 sm:text-5xl lg:text-balance"
          >
            Everything you need to store your warranties and invoices.
          </p>
          <p class="mt-6 text-lg/8 text-gray-600">
            Uploading warranties as well as invoices in different file types.
          </p>
        </div>
        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
          <div
            class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16"
          >
            <div class="relative pl-16">
              <div class="text-base/7 font-semibold text-gray-900">
                <div
                  class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-yellow-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1.2em"
                    height="1.2em"
                    viewBox="0 0 48 48"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="4"
                      d="M11.678 20.271C7.275 21.318 4 25.277 4 30c0 5.523 4.477 10 10 10c.947 0 1.864-.132 2.733-.378m19.322-19.351c4.403 1.047 7.677 5.006 7.677 9.729c0 5.523-4.477 10-10 10c-.947 0-1.864-.132-2.732-.378M36 20c0-6.627-5.373-12-12-12s-12 5.373-12 12m5.065 7.881L24 20.924L31.132 28M24 38V24.462"
                    />
                  </svg>
                </div>
                Document upload
              </div>
              <div class="mt-2 text-base/7 text-gray-600">
                Allows users to upload invoices and warranty certificates in
                PDF, WORD, PNG, and JPG formats.
              </div>
            </div>
            <div class="relative pl-16">
              <div class="text-base/7 font-semibold text-gray-900">
                <div
                  class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-yellow-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1.2em"
                    height="1.2em"
                    viewBox="0 0 16 16"
                  >
                    <path
                      fill="currentColor"
                      d="M9.93 4.138a1.25 1.25 0 0 1 1.14 0l2.25 1.155c.418.214.68.643.68 1.112v3.189c0 .469-.262.898-.68 1.112l-2.25 1.155a1.25 1.25 0 0 1-1.14 0l-2.25-1.155A1.25 1.25 0 0 1 7 9.594v-3.19c0-.468.262-.897.68-1.111zM8.552 6.775a.5.5 0 0 0 .223.671L10 8.058v1.441a.5.5 0 0 0 1 0V8.058l1.224-.612a.5.5 0 1 0-.448-.894L10.5 7.19l-1.276-.638a.5.5 0 0 0-.671.223M1.5 7.5a.5.5 0 0 0 0 1h3a.5.5 0 1 0 0-1zm.5-2a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m.5 4.5a.5.5 0 0 0 0 1h3a.5.5 0 1 0 0-1z"
                    />
                  </svg>
                </div>
                Quick access to documents
              </div>
              <div class="mt-2 text-base/7 text-gray-600">
                Provides the ability to quickly search through invoices and
                warranties.
              </div>
            </div>
            <div class="relative pl-16">
              <div class="text-base/7 font-semibold text-gray-900">
                <div
                  class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-yellow-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1.2em"
                    height="1.2em"
                    viewBox="0 0 48 48"
                  >
                    <path
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="4"
                      d="M11.678 20.271C7.275 21.318 4 25.277 4 30c0 5.523 4.477 10 10 10c.947 0 1.864-.132 2.733-.378m19.322-19.351c4.403 1.047 7.677 5.006 7.677 9.729c0 5.523-4.477 10-10 10c-.947 0-1.864-.132-2.732-.378M36 20c0-6.627-5.373-12-12-12s-12 5.373-12 12m5.065 7.881L24 20.924L31.132 28M24 38V24.462"
                    />
                  </svg>
                </div>
                Download the documents
              </div>
              <div class="mt-2 text-base/7 text-gray-600">
                Download the documents in their original format whenever you
                want.
              </div>
            </div>
            <div class="relative pl-16">
              <div class="text-base/7 font-semibold text-gray-900">
                <div
                  class="absolute top-0 left-0 flex size-10 items-center justify-center rounded-lg bg-yellow-300"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="1.2em"
                    height="1.2em"
                    viewBox="0 0 24 24"
                  >
                    <g
                      fill="none"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                    >
                      <circle cx="17" cy="7" r="3" />
                      <circle cx="7" cy="17" r="3" />
                      <path
                        d="M14 14h6v5a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zM4 4h6v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z"
                      />
                    </g>
                  </svg>
                </div>
                Organize documents
              </div>
              <div class="mt-2 text-base/7 text-gray-600">
                Organizing invoices and warranties into categories is easy
                thanks to the numerous filters.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16">
        <div
          class="bg-white rounded-lg border border-neutral-200 p-8 md:p-12 mb-8"
        >
          <h1
            class="text-gray-900 text-3xl md:text-4xl font-extrabold mb-9 text-center"
          >
            The benefits of using our platform.
          </h1>
          <div
            class="space-y-4 text-lg font-medium text-gray-600 mb-6 list-disc list-inside ml-2 sm:ml-8"
          >
            <div class="flex items-center space-x-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2vw"
                height="1.2vw"
                viewBox="0 0 24 24"
                class="mr-2 mt-1 size-5 flex-none text-yellow-300"
              >
                <path
                  fill="currentColor"
                  d="m9.55 15.15l8.475-8.475q.3-.3.7-.3t.7.3t.3.713t-.3.712l-9.175 9.2q-.3.3-.7.3t-.7-.3L4.55 13q-.3-.3-.288-.712t.313-.713t.713-.3t.712.3z"
                />
              </svg>
              <div class="text-base sm:text-lg">
                Secure storage of important documents.
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2vw"
                height="1.2vw"
                viewBox="0 0 24 24"
                class="mr-2 mt-1 size-5 flex-none text-yellow-300"
              >
                <path
                  fill="currentColor"
                  d="m9.55 15.15l8.475-8.475q.3-.3.7-.3t.7.3t.3.713t-.3.712l-9.175 9.2q-.3.3-.7.3t-.7-.3L4.55 13q-.3-.3-.288-.712t.313-.713t.713-.3t.712.3z"
                />
              </svg>
              <div class="text-base sm:text-lg">
                The ability to track warranty validity periods.
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2vw"
                height="1.2vw"
                viewBox="0 0 24 24"
                class="mr-2 mt-1 size-5 flex-none text-yellow-300"
              >
                <path
                  fill="currentColor"
                  d="m9.55 15.15l8.475-8.475q.3-.3.7-.3t.7.3t.3.713t-.3.712l-9.175 9.2q-.3.3-.7.3t-.7-.3L4.55 13q-.3-.3-.288-.712t.313-.713t.713-.3t.712.3z"
                />
              </svg>
              <div class="text-base sm:text-lg">
                By keeping documents in digital format, the need to print papers
                is reduced, thus contributing to the protection of the
                environment.
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2vw"
                height="1.2vw"
                viewBox="0 0 24 24"
                class="mr-2 mt-1 size-5 flex-none text-yellow-300"
              >
                <path
                  fill="currentColor"
                  d="m9.55 15.15l8.475-8.475q.3-.3.7-.3t.7.3t.3.713t-.3.712l-9.175 9.2q-.3.3-.7.3t-.7-.3L4.55 13q-.3-.3-.288-.712t.313-.713t.713-.3t.712.3z"
                />
              </svg>
              <div class="text-base sm:text-lg">
                The platform can organize documents into categories, making it
                easier to search and manage them.
              </div>
            </div>
          </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">
          <div
            class="bg-white border border-neutral-200 rounded-lg p-8 md:p-12"
          >
            <h2 class="text-3xl flex font-bold text-gray-900 mb-6 text-left">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1.2em"
                height="1.2em"
                viewBox="0 0 48 48"
                class="mr-2"
              >
                <g
                  fill="none"
                  stroke="currentColor"
                  stroke-linejoin="round"
                  stroke-width="4"
                >
                  <rect width="36" height="36" x="6" y="6" rx="3" />
                  <path stroke-linecap="round" d="M6 17h36M17 42V17" />
                </g>
              </svg>
              Warranties
            </h2>

            <div class="space-y-6">
              <div class="flex items-start space-x-3">
                <span class="text-yellow-300 text-2xl">•</span>
                <p class="text-lg text-gray-700 leading-relaxed">
                  Digital warranty storage helps you keep all your important
                  documents in one place. Without the risk of losing them or
                  forgetting about them – make sure you always have quick access
                  to them!
                </p>
              </div>

              <div class="flex items-start space-x-3">
                <span class="text-yellow-300 text-2xl">•</span>
                <p class="text-lg text-gray-700 leading-relaxed">
                  Start protecting your warranties now, without risking losing
                  them. Creating an account gives you easy and secure management
                  of all your warranties.
                </p>
              </div>
            </div>
          </div>

          <div
            class="bg-white border border-neutral-200 rounded-lg p-8 md:p-12"
          >
            <h2 class="text-gray-900 flex text-3xl font-extrabold mb-4">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 -960 960 960"
                fill="#000000"
                width="1.2em"
                height="1.2em"
                class="mr-2"
              >
                <path
                  d="M340-460h280v-64H340v64Zm0 120h280v-64H340v64Zm0 120h174v-64H340v64ZM263.72-96Q234-96 213-117.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v504q0 29.7-21.16 50.85Q725.68-96 695.96-96H263.72ZM528-624v-168H264v624h432v-456H528ZM264-792v168-168 624-624Z"
                /></svg
              >Invoices
            </h2>

            <div class="flex items-start space-x-3">
              <span class="text-yellow-300 text-2xl">•</span>
              <p class="text-lg text-gray-700 leading-relaxed">
                No more cluttered drawers with papers, no more fear of losing
                important invoices. We provide you with a safe and accessible
                place to organize all your invoices. Whether you’ve purchased a
                product online, in-store, or paid a service bill, all you have
                to do is upload them to your account.
              </p>
            </div>

            <div class="flex items-start space-x-3 space-y-6">
              <span class="text-yellow-300 text-2xl">•</span>
              <p class="text-lg text-gray-700 leading-relaxed">
                Start digitizing your invoices now and enjoy the convenience of
                efficient management, without scattered papers!
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-white pb-12">
      <div
        class="py-4 px-4 mx-auto max-w-screen-xl lg:py-10 bg-white sm:px-10"
      >
        <div class="mx-auto px-5">
          <div class="flex flex-col items-center">
            <h2
              class="mt-5 flex items-center justify-center text-center text-3xl font-bold tracking-tight md:text-5xl"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="1em"
                height="1em"
                viewBox="0 0 24 24"
                class="mr-2"
              >
                <g fill="none">
                  <path
                    d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"
                  />
                  <path
                    fill="currentColor"
                    d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2m0 2a8 8 0 1 0 0 16a8 8 0 0 0 0-16m0 12a1 1 0 1 1 0 2a1 1 0 0 1 0-2m0-9.5a3.625 3.625 0 0 1 1.348 6.99a.8.8 0 0 0-.305.201c-.044.05-.051.114-.05.18L13 14a1 1 0 0 1-1.993.117L11 14v-.25c0-1.153.93-1.845 1.604-2.116a1.626 1.626 0 1 0-2.229-1.509a1 1 0 1 1-2 0A3.625 3.625 0 0 1 12 6.5"
                  />
                </g>
              </svg>

              FAQ
            </h2>
            <p class="mt-3 text-base text-neutral-500 md:text-xl">
              Frequenty asked questions
            </p>
          </div>
          <div class="mx-auto mt-8 grid max-w-xl divide-y divide-neutral-200">
            <div v-for="(item, index) in faqItems" :key="index" class="py-5">
              <details class="group">
                <summary
                  class="flex cursor-pointer list-none items-center justify-between font-medium"
                >
                  <span
                    class="hover:underline decoration-yellow-300 underline-offset-2"
                    >{{ item.question }}</span
                  >
                  <span
                    class="transition group-open:rotate-180 text-yellow-300"
                  >
                    <svg
                      fill="none"
                      height="24"
                      shape-rendering="geometricPrecision"
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="1.5"
                      viewBox="0 0 24 24"
                      width="24"
                    >
                      <path d="M6 9l6 6 6-6"></path>
                    </svg>
                  </span>
                </summary>
                <p class="group-open:animate-fadeIn mt-3 text-neutral-600 ml-3">
                  {{ item.answer }}
                </p>
              </details>
            </div>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>
<style scoped></style>
