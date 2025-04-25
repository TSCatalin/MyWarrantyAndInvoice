<script setup>
const currentYear = new Date().getFullYear();
</script>
<template>
  <footer class="bg-gray-100">
    <div class="mx-auto w-full max-w-screen-xl p-8 py-6 lg:py-8">
      <div class="md:flex md:justify-between">
        <div class="mb-6 md:mb-0">
          <RouterLink
            :to="{ name: 'HomeGuest' }"
            class="flex items-center mb-3"
          >
            <span class="self-center text-3xl font-semibold whitespace-nowrap hover:underline underline-offset-4 decoration-yellow-300">
              MY Warranty and Invoice</span
            >
          </RouterLink>
          <div class="w-96 md:w-1/2 text-neutral-600 ml-6">
            Keep your invoices and warranties in a safe and easily accessible
            place. Our platform helps you manage all your important documents.
          </div>

          <div
            class="mt-10 text-3xl underline underline-offset-4 decoration-yellow-300"
          >
            Follow Us
          </div>
          <div class="flex gap-3 mt-6">
            <a href="#"
              ><div
                class="border-2 rounded-lg p-1 border-black hover:border-yellow-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="2em"
                  height="2em"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95"
                  />
                </svg></div
            ></a>
            <a href="#"
              ><div
                class="border-2 rounded-lg p-1 border-black hover:border-yellow-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="2em"
                  height="2em"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3"
                  />
                </svg></div
            ></a>
            <a href="#"
              ><div
                class="border-2 rounded-lg p-1 border-black hover:border-yellow-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="2em"
                  height="2em"
                  viewBox="0 0 14 14"
                >
                  <g fill="none">
                    <g clip-path="url(#primeTwitter0)">
                      <path
                        fill="currentColor"
                        d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z"
                      />
                    </g>
                    <defs>
                      <clipPath id="primeTwitter0">
                        <path fill="#fff" d="M0 0h14v14H0z" />
                      </clipPath>
                    </defs>
                  </g>
                </svg></div
            ></a>
            <a href="#"
              ><div
                class="border-2 rounded-lg p-1 border-black hover:border-yellow-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="2em"
                  height="2em"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="m10 15l5.19-3L10 9zm11.56-7.83c.13.47.22 1.1.28 1.9c.07.8.1 1.49.1 2.09L22 12c0 2.19-.16 3.8-.44 4.83c-.25.9-.83 1.48-1.73 1.73c-.47.13-1.33.22-2.65.28c-1.3.07-2.49.1-3.59.1L12 19c-4.19 0-6.8-.16-7.83-.44c-.9-.25-1.48-.83-1.73-1.73c-.13-.47-.22-1.1-.28-1.9c-.07-.8-.1-1.49-.1-2.09L2 12c0-2.19.16-3.8.44-4.83c.25-.9.83-1.48 1.73-1.73c.47-.13 1.33-.22 2.65-.28c1.3-.07 2.49-.1 3.59-.1L12 5c4.19 0 6.8.16 7.83.44c.9.25 1.48.83 1.73 1.73"
                  />
                </svg></div
            ></a>
            <a href="#"
              ><div
                class="border-2 rounded-lg p-1 border-black hover:border-yellow-300"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="2em"
                  height="2em"
                  viewBox="0 0 24 24"
                >
                  <path
                    fill="currentColor"
                    d="M16.6 5.82s.51.5 0 0A4.28 4.28 0 0 1 15.54 3h-3.09v12.4a2.59 2.59 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6c0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64c0 3.33 2.76 5.7 5.69 5.7c3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48"
                  />
                </svg></div
            ></a>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3 mt-16 md:mt-2">
          <div>
            <h2 class="mb-6 text-base font-semibold text-black uppercase">
              Pages
            </h2>
            <ul class="text-neutral-500 font-medium">
              <li class="mb-4">
                <RouterLink :to="{ name: 'HomeGuest' }" class="hover:underline text-base"
                  >Home</RouterLink
                >
              </li>
              <li class="mb-4">
                <RouterLink :to="{ name: 'AboutGuest' }" class="hover:underline text-base" 
                  >About</RouterLink
                >
              </li>
              <li>
                <a href="#" class="hover:underline">Contact</a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-6 text-base font-semibold text-gray-900 uppercase">
              Legal
            </h2>
            <ul class="text-neutral-500 font-medium">
              <li class="mb-4">
                <a href="#" class="hover:underline">Privacy Policy</a>
              </li>
              <li>
                <a href="#" class="hover:underline">Terms &amp; Conditions</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
        <span class="text-sm text-gray-500 sm:text-center"
          >@{{ currentYear }}
          <RouterLink :to="{ name: 'HomeGuest' }" class="hover:underline"
            >MY Warranty and Invoice</RouterLink
          >. All Rights Reserved.
        </span>
      </div>
    </div>
  </footer>
</template>

<style scoped></style>
