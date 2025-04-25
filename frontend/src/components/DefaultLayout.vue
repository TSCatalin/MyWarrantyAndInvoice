<template>
  <div
    class="bg-white hidden lg:block border-b-2 border-neutral-300 sticky top-0 z-30"
  >
    <div class="px-4">
      <div class="flex h-16 items-center justify-between">
        <div class="text-black text-xl font-bold">MY Warranty and Invoice</div>
        <div class="ml-4 flex items-center">
          <Menu as="div" class="relative">
            <div>
              <MenuButton
                class="relative cursor-pointer flex max-w-xs items-center rounded-lg bg-white border border-neutral-300 hover:border-yellow-300 hover:bg-neutral-50 text-sm"
              >
                <div class="text-black p-2 pr-4 pl-4 flex">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="24px"
                    viewBox="0 -960 960 960"
                    width="24px"
                    fill="#000000"
                    class="mr-2"
                  >
                    <path
                      d="M480-480q-60 0-102-42t-42-102q0-60 42-102t102-42q60 0 102 42t42 102q0 60-42 102t-102 42ZM192-192v-96q0-23 12.5-43.5T239-366q55-32 116.29-49 61.29-17 124.5-17t124.71 17Q666-398 721-366q22 13 34.5 34t12.5 44v96H192Zm72-72h432v-24q0-5.18-3.03-9.41-3.02-4.24-7.97-6.59-46-28-98-42t-107-14q-55 0-107 14t-98 42q-5 4-8 7.72-3 3.73-3 8.28v24Zm216.21-288Q510-552 531-573.21t21-51Q552-654 530.79-675t-51-21Q450-696 429-674.79t-21 51Q408-594 429.21-573t51 21Zm-.21-72Zm0 360Z"
                    />
                  </svg>
                  {{ user.name }}
                </div>
              </MenuButton>
            </div>
            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden"
              >
                <RouterLink
                  v-for="item in userNavigation"
                  :key="item.name"
                  :to="item.to"
                  :class="[
                    $route.name === item.to.name
                      ? 'bg-gray-100 outline-hidden'
                      : 'block px-4 py-2 text-sm text-gray-700 hover:bg-neutral-50',
                    'rounded-md px-3 py-2 text-sm text-start',
                  ]"
                  :aria-current="
                    $route.name === item.to.name ? 'page' : undefined
                  "
                >
                  {{ item.name }}
                </RouterLink>
                <MenuItem>
                  <button
                    @click="logout"
                    class="w-full text-start px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-neutral-50"
                  >
                    Sign out
                  </button>
                </MenuItem>
              </MenuItems>
            </transition>
          </Menu>
        </div>
      </div>
    </div>
  </div>

  <div class="min-h-screen flex">
    <Disclosure
      as="nav"
      class="bg-white lg:flex hidden w-64 min-h-screen flex-col border-r-2 border-neutral-300 fixed top-0 left-0 z-20 mt-16"
    >
      <div class="flex flex-col items-center space-y-4 px-4 pt-6">
        <RouterLink
          v-for="item in navigation"
          :key="item.name"
          :to="item.to"
          :class="[
            $route.name === item.to.name
              ? 'bg-yellow-300 border-yellow-300 text-black'
              : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
            'rounded-md w-full text-center px-4 py-2.5 text-sm font-medium',
          ]"
          :aria-current="$route.name === item.to.name ? 'page' : undefined"
        >
          <div class="flex">
            <span v-html="item.icon" class="mr-2"></span>
            {{ item.name }}
          </div>
        </RouterLink>
      </div>

      <div class="border-t border-white pb-4">
        <div class="flex flex-col items-center space-y-4 px-4 py-4">
          <RouterLink
            v-for="item in userNavigation"
            :key="item.name"
            :to="item.to"
            :class="[
              $route.name === item.to.name
                ? 'bg-yellow-300 border-yellow-300 text-black'
                : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
              'rounded-md w-full text-center px-4 py-2.5 text-sm font-medium',
            ]"
            :aria-current="$route.name === item.to.name ? 'page' : undefined"
          >
            <div class="flex">
              <span v-html="item.icon" class="mr-2"></span>
              {{ item.name }}
            </div>
          </RouterLink>
          <DisclosureButton
            @click="logout"
            class="rounded-md w-full cursor-pointer text-center px-4 py-2.5 text-sm font-medium text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50"
          >
            <div class="flex">
              <svg
                class="shrink-0 w-5 mr-3 h-5 text-black transition duration-75 group-hover:text-gray-900"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 18 16"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                />
              </svg>
              Sign out
            </div>
          </DisclosureButton>
        </div>
      </div>
    </Disclosure>

    <div class="flex-1 bg-gray-100">
      <Disclosure
        as="nav"
        class="lg:hidden bg-white border-b-2 border-neutral-300 sticky top-0 z-30"
      >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
          <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
              <div class="shrink-0 text-black text-xl font-bold">
                MY Warranty and Invoice
              </div>
            </div>
            <div class="-mr-2 flex lg:hidden">
              <DisclosureButton
                class="inline-flex items-center border border-neutral-300 justify-center rounded-md bg-white p-2 text-gray-400 hover:border-yellow-300 hover:text-black focus:outline-none"
              >
                <Bars3Icon v-if="!open" class="block w-6 h-6" />
                <XMarkIcon v-else class="block w-6 h-6" />
              </DisclosureButton>
            </div>
          </div>
        </div>

        <DisclosurePanel class="lg:hidden">
          <div
            class="flex flex-col items-center space-y-2 px-4 py-4 pt-2 pb-3 sm:px-3"
          >
            <RouterLink
              v-for="item in navigation"
              :key="item.name"
              :to="item.to"
              :class="[
                $route.name === item.to.name
                  ? 'bg-yellow-300 border-yellow-300 text-black'
                  : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
                'rounded-md w-full text-center px-4 py-2.5 text-sm font-medium',
              ]"
              :aria-current="$route.name === item.to.name ? 'page' : undefined"
            >
              <div class="flex">
                <span v-html="item.icon" class="mr-2"></span>
                {{ item.name }}
              </div>
            </RouterLink>
          </div>

          <div class="">
            <div class="flex flex-col items-center space-y-2 px-4 py-4 pt-2 pb-3 sm:px-3">
              <RouterLink
                v-for="item in userNavigation"
                :key="item.name"
                :to="item.to"
                :class="[
                  $route.name === item.to.name
                    ? 'bg-yellow-300 border-yellow-300 text-black'
                    : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
                  'rounded-md w-full text-center px-4 py-2.5 text-sm font-medium',
                ]"
                :aria-current="
                  $route.name === item.to.name ? 'page' : undefined
                "
              >
                <div class="flex justify-start">
                  <span v-html="item.icon" class="mr-2"></span>
                  {{ item.name }}
                </div>
              </RouterLink>
              <DisclosureButton
                @click="logout"
                class="rounded-md w-full cursor-pointer text-center px-4 py-2.5 text-sm font-medium text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50"
              >
                <div class="flex justify-start">
                  <svg
                    class="shrink-0 w-5 mr-3 h-5 text-black transition duration-75 group-hover:text-gray-900"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 18 16"
                  >
                    <path
                      stroke="currentColor"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                    />
                  </svg>
                  Sign out
                </div>
              </DisclosureButton>
            </div>
          </div>
        </DisclosurePanel>
      </Disclosure>

      <div class="flex-1 bg-gray-100 lg:ml-64">
        <RouterView />
      </div>
    </div>
  </div>
</template>

<script setup>
import {
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
} from "@headlessui/vue";
import { Bars3Icon, XMarkIcon } from "@heroicons/vue/24/outline";
import { RouterLink } from "vue-router";
import axiosClient from "../axios";
import useUserStore from "../store/user";
import { computed } from "vue";
import router from "../router";

const userStore = useUserStore();

const user = computed(() => userStore.user);

const navigation = [
  {
    name: "Dashboard",
    to: { name: "Home" },
    icon: `<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M13 9V3h8v6zM3 13V3h8v10zm10 8V11h8v10zM3 21v-6h8v6zm2-10h4V5H5zm10 8h4v-6h-4zm0-12h4V5h-4zM5 19h4v-2H5zm4-2"/></svg>`,
  },
   {
    name: "History",
    to: { name: "History" },
    icon: `<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 21q-3.15 0-5.575-1.912T3.275 14.2q-.1-.375.15-.687t.675-.363q.4-.05.725.15t.45.6q.6 2.25 2.475 3.675T12 19q2.925 0 4.963-2.037T19 12t-2.037-4.962T12 5q-1.725 0-3.225.8T6.25 8H8q.425 0 .713.288T9 9t-.288.713T8 10H4q-.425 0-.712-.288T3 9V5q0-.425.288-.712T4 4t.713.288T5 5v1.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924t1.925 2.85T21 12t-.712 3.513t-1.925 2.85t-2.85 1.925T12 21m1-9.4l2.5 2.5q.275.275.275.7t-.275.7t-.7.275t-.7-.275l-2.8-2.8q-.15-.15-.225-.337T11 11.975V8q0-.425.288-.712T12 7t.713.288T13 8z"/></svg>`,
  },
  {
    name: "Warranty",
    to: { name: "MyWarranty" },
    icon: `<svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" viewBox="0 0 48 48"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4"><rect width="36" height="36" x="6" y="6" rx="3"/><path stroke-linecap="round" d="M6 17h36M17 42V17"/></g></svg>`,
  },
  {
    name: "Invoice",
    to: { name: "MyInvoice" },
    icon: `<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M340-460h280v-64H340v64Zm0 120h280v-64H340v64Zm0 120h174v-64H340v64ZM263.72-96Q234-96 213-117.15T192-168v-624q0-29.7 21.15-50.85Q234.3-864 264-864h312l192 192v504q0 29.7-21.16 50.85Q725.68-96 695.96-96H263.72ZM528-624v-168H264v624h432v-456H528ZM264-792v168-168 624-624Z"/></svg>`,
  },
];
const userNavigation = [
  {
    name: "Your Profile",
    to: { name: "YourProfile" },
    icon: `<svg
                  xmlns="http://www.w3.org/2000/svg"
                  height="24px"
                  viewBox="0 -960 960 960"
                  width="24px"
                  fill="#000000"
                >
                  <path
                    d="M480-480q-60 0-102-42t-42-102q0-60 42-102t102-42q60 0 102 42t42 102q0 60-42 102t-102 42ZM192-192v-96q0-23 12.5-43.5T239-366q55-32 116.29-49 61.29-17 124.5-17t124.71 17Q666-398 721-366q22 13 34.5 34t12.5 44v96H192Zm72-72h432v-24q0-5.18-3.03-9.41-3.02-4.24-7.97-6.59-46-28-98-42t-107-14q-55 0-107 14t-98 42q-5 4-8 7.72-3 3.73-3 8.28v24Zm216.21-288Q510-552 531-573.21t21-51Q552-654 530.79-675t-51-21Q450-696 429-674.79t-21 51Q408-594 429.21-573t51 21Zm-.21-72Zm0 360Z"
                  />
                </svg>`,
  },
];

function logout() {
  axiosClient.post("logout").then((response) => {
    router.push({ name: "Login" });
  });
}
</script>
<style scoped></style>
