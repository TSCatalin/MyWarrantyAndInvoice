<script setup>
import AboutImage from "../components/AboutImage.vue";

const cards = [
  {
    title: "Fast and secure upload",
    description:
      "You upload invoices and warranty certificates quickly and securely.",
    icon: `
     <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"> <g fill="none" fill-rule="evenodd">
      <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/>
      <path fill="currentColor"
        d="m9.65 4l-3.111 7h3.447c.69 0 1.176.675.958 1.33l-1.656 4.967L16.586 10h-2.57a1.01 1.01 0 0 1-.903-1.462L15.382 4zM8.084 2.6c.162-.365.523-.6.923-.6h7.977c.75 0 1.239.79.903 1.462L15.618 8h3.358c.9 0 1.35 1.088.714 1.724L7.737 21.677c-.754.754-2.01-.022-1.672-1.033L8.613 13H5.015a1.01 1.01 0 0 1-.923-1.42z"/></g>
     </svg>
    `,
  },
  {
    title: "Simple document organization",
    description: "You organize documents by categories for easy accessibility.",
    icon: `
       <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
        <path fill="currentColor" d="M11.75 1.998a3.752 3.752 0 0 0-.75 7.43V11.5H7.75a2.25 2.25 0 0 0-2.25 2.25v.826a3.754 3.754 0 0 0 .752 7.429A3.752 3.752 0 0 0 7 14.575v-.825a.75.75 0 0 1 .75-.75h8a.75.75 0 0 1 .75.75v.826a3.754 3.754 0 0 0 .752 7.429a3.752 3.752 0 0 0 .748-7.43v-.825a2.25 2.25 0 0 0-2.25-2.25H12.5V9.428a3.754 3.754 0 0 0-.75-7.43M9.498 5.75a2.252 2.252 0 1 1 4.504 0a2.252 2.252 0 0 1-4.504 0M4 18.253a2.252 2.252 0 1 1 4.505 0a2.252 2.252 0 0 1-4.505 0M17.252 16a2.252 2.252 0 1 1 0 4.505a2.252 2.252 0 0 1 0-4.505"/>
       </svg>
    `,
  },
  {
    title: "Warranty expiration notifications",
    description:
      "You receive notifications for warranty expirations, so you don't miss important deadlines.",
    icon: `
      <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
        <path fill="currentColor" d="M4 19v-2h2v-7q0-2.075 1.25-3.687T10.5 4.2v-.7q0-.625.438-1.062T12 2t1.063.438T13.5 3.5v.7q2 .5 3.25 2.113T18 10v7h2v2zm8 3q-.825 0-1.412-.587T10 20h4q0 .825-.587 1.413T12 22m-4-5h8v-7q0-1.65-1.175-2.825T12 6T9.175 7.175T8 10z"/>
      </svg>
    `,
  },
  {
    title: "Quick document search",
    description:
      "You can quickly find any document using the efficient search function.",
    icon: `
     <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24">
        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
      </svg>
    `,
  },
];
</script>

<template>
  <GuestLayout>
    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-24">
        <div
          class="text-black text-5xl font-bold underline underline-offset-4 decoration-yellow-300"
        >
          About Us
        </div>
      </div>
    </section>
    <section class="bg-white">
      <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-8">
        <div class="flex justify-between items-stretch">
          <div
            class="w-1/2 bg-white hidden md:block"
          >
            <AboutImage/>
          </div>
          <div class="bg-white rounded-lg p-8 md:p-12 mb-8 w-full md:w-1/2">
            <h1
              class="text-gray-900 text-3xl md:text-4xl font-extrabold mb-9 text-center"
            >
              We are committed to making the management of important documents
              as easy and secure as possible for you.
            </h1>
            <div
              class="space-y-4 text-lg font-medium text-gray-600 mb-6 list-disc list-inside ml-2 sm:ml-8"
            >
              Our platform provides you with a safe and convenient place to
              store and organize your product warranties and invoices, so you
              can always have them on hand when you need them.
              <div
                class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 mt-6"
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
              </div>
            </div>
          </div>
        </div>

        <div
          class="text-gray-900 text-3xl md:text-4xl font-extrabold mb-9 text-left pt-2 md:pt-20 ml-4"
        >
          Our mission
        </div>

        <div class="text-gray-600 text-xl text-justify md:text-2xl mb-14 px-8">
          Our mission is to give you peace of mind that your important documents
          are safe and accessible at any time.
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-2 sm:px-8">
          <div
            v-for="(card, index) in cards"
            :key="index"
            class="bg-white border border-neutral-300 hover:border-yellow-300 p-8 rounded-xl space-y-4"
          >
            <h2
              class="text-gray-900 text-2xl font-extrabold flex items-center justify-left mb-4"
            >
              <div
                class="bg-yellow-300 rounded-xl p-2 mr-3"
                v-html="card.icon"
              />
              {{ card.title }}
            </h2>
            <p class="text-gray-600 text-base mt-5 px-5">
              {{ card.description }}
            </p>
          </div>
        </div>
        <div
          class="text-gray-600 text-xl text-justify md:text-2xl mt-14 mb-14 px-4 md:px-10"
        >
          Whether it's an electronic product, home appliance, or any other type
          of purchase, we provide you with the ability to quickly save and
          access warranty and invoice documents.
        </div>

        <div
          class="text-gray-600 text-xl text-justify font-semibold md:text-2xl mt-14 mb-14 px-8 md:px-14"
        >
          We are committed to protecting the confidentiality and security of
          your data by using the latest encryption technologies.
        </div>

        <div class="px-2 md:px-8 mb-12 mt-5">
          <div
            class="bg-white rounded-lg p-6 md:p-8 mb-8 w-full border border-yellow-300"
          >
            <div class="flex justify-center">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="2em"
                height="2em"
                viewBox="0 0 24 24"
                class="w-32 h-32"
              >
                <path
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="1.5"
                  d="M7 18v-1a5 5 0 0 1 5-5v0a5 5 0 0 1 5 5v1M1 18v-1a3 3 0 0 1 3-3v0m19 4v-1a3 3 0 0 0-3-3v0m-8-2a3 3 0 1 0 0-6a3 3 0 0 0 0 6m-8 2a2 2 0 1 0 0-4a2 2 0 0 0 0 4m16 0a2 2 0 1 0 0-4a2 2 0 0 0 0 4"
                />
              </svg>
            </div>

            <div
              class="space-y-4 text-2xl text-center font-extrabold text-gray-900 mb-8 list-disc list-inside ml-2 sm:ml-8"
            >
              Join our community and discover how easy it is to manage your
              documents!
            </div>
            <div class="flex justify-center items-center">
              <RouterLink
                :to="{ name: 'Signup' }"
                class="flex justify-center w-96 items-center py-3.5 px-14 text-lg font-medium text-center text-black rounded-lg bg-yellow-300 hover:bg-yellow-400"
              >
                Join now
                <svg
                  class="w-3.5 h-3.5 ms-2 mt-0.5"
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
            </div>
          </div>
        </div>
      </div>
    </section>
  </GuestLayout>
</template>
<style scoped></style>
