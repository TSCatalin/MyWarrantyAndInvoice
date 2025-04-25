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
import GuestFooter from "./GuestFooter.vue";
import { computed } from "vue";
import { useRoute } from "vue-router";
import LogoImage from "./LogoImage.vue";

const route = useRoute();
const navigation = [
  { name: "Home", to: { name: "HomeGuest" } },
  { name: "About", to: { name: "AboutGuest" } },
];
const userNavigation = [
  { name: "Register", to: { name: "Signup" } },
  { name: "Login", to: { name: "Login" } },
];

const userNavigationDropDown = [
  {
    name: "FAQ",
    to: { name: "FAQGuest" },
  },
  { name: "Contact", to: { name: "ContactGuest" } },
];

const isInDropdown = computed(() =>
  userNavigationDropDown.some((item) => item.to.name === route.name)
);
</script>

<template>
  <div class="min-h-full">
    <Disclosure as="nav" class="bg-white sticky top-0 z-30" v-slot="{ open }">
      <div class="px-4 lg:px-10">
        <div class="flex h-20 items-center justify-between">
          <div class="flex items-center justify-between w-full">
            <div class="text-black text-base lg:text-lg font-bold flex items-center">
              <LogoImage class="mr-2"/>
              MY Warranty and Invoice
            </div>

            <div class="hidden md:block">
              <div class="flex items-baseline space-x-4">
                <RouterLink
                  v-for="item in navigation"
                  :key="item.name"
                  :to="item.to"
                  :class="[
                    $route.name === item.to.name
                      ? 'bg-yellow-300 border-yellow-300 text-black'
                      : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
                    'rounded-xl w-full text-center px-4 lg:px-8 py-2.5 text-xs lg:text-sm font-medium',
                  ]"
                  :aria-current="
                    $route.name === item.to.name ? 'page' : undefined
                  "
                  >{{ item.name }}</RouterLink
                >

                <div class="flex items-center">
                  <Menu as="div" class="relative inline-block text-left">
                    <MenuButton
                      v-slot="{ open }"
                      :class="[
                        'relative cursor-pointer rounded-xl w-full text-center px-3 lg:px-6 py-1.5 lg:py-2 text-xs lg:text-sm font-medium border',
                        isInDropdown
                          ? 'bg-yellow-300 border-yellow-300 text-black'
                          : 'bg-white border-neutral-300 text-black hover:border-yellow-300 hover:bg-neutral-50',
                      ]"
                    >
                      <div class="text-black flex items-center justify-between">
                        Info
                        <span
                          :class="[
                            'ml-2 transition-transform duration-300',
                            open ? 'rotate-180' : '',
                            isInDropdown ? 'text-black' : 'text-yellow-300',
                          ]"
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
                      </div>
                    </MenuButton>

                    <transition
                      enter-active-class="transition ease-out duration-100"
                      enter-from-class="transform opacity-0 scale-95"
                      enter-to-class="transform opacity-100 scale-100"
                      leave-active-class="transition ease-in duration-75"
                      leave-from-class="transform opacity-100 scale-100"
                      leave-to-class="transform opacity-0 scale-95"
                    >
                      <MenuItems
                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden"
                      >
                        <RouterLink
                          v-for="item in userNavigationDropDown"
                          :key="item.name"
                          :to="item.to"
                          :class="[
                            'px-4 py-2 text-sm text-start w-full flex flex-col',
                            $route.name === item.to.name
                              ? 'bg-yellow-300 border-yellow-300 text-black'
                              : 'bg-white text-black hover:bg-neutral-100',
                          ]"
                          :aria-current="
                            $route.name === item.to.name ? 'page' : undefined
                          "
                        >
                          {{ item.name }}
                        </RouterLink>
                      </MenuItems>
                    </transition>
                  </Menu>
                </div>
              </div>
            </div>

            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-1">
                <RouterLink
                  v-for="item in userNavigation"
                  :key="item.name"
                  :to="item.to"
                  :class="[
                    $route.name === item.to.name
                      ? 'bg-neutral-200 border-yellow-300 text-black'
                      : 'text-black border border-neutral-100 bg-neutral-100 hover:border-yellow-300 hover:bg-neutral-50',
                    'rounded-xl w-full text-center px-4 py-2.5 text-xs lg:text-sm font-medium',
                  ]"
                  :aria-current="
                    $route.name === item.to.name ? 'page' : undefined
                  "
                  >{{ item.name }}</RouterLink
                >
              </div>
            </div>
          </div>
          <div class="-mr-2 flex md:hidden">
            <DisclosureButton
              class="relative inline-flex items-center border border-neutral-300 justify-center rounded-md bg-white p-2 text-gray-400 hover:border-yellow-300 hover:text-black focus:outline-none"
            >
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open main menu</span>
              <Bars3Icon v-if="!open" class="block size-6" aria-hidden="true" />
              <XMarkIcon v-else class="block size-6" aria-hidden="true" />
            </DisclosureButton>
          </div>
        </div>
      </div>

      <DisclosurePanel class="md:hidden">
        <div class="flex flex-col items-center space-y-2 px-4 pt-4 sm:px-3">
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
            >{{ item.name }}</RouterLink
          >
        </div>

        <div
          class="flex flex-col items-center space-y-2 px-4 py-4 pt-2 pb-3 sm:px-3"
        >
          <Menu as="div" class="w-full text-left">
            <MenuButton
              v-slot="{ open }"
              :class="[
                'rounded-md w-full text-center px-4 py-2.5 text-sm font-medium flex items-center justify-center',
                isInDropdown
                  ? 'bg-yellow-300 border-yellow-300 text-black'
                  : 'text-black border border-neutral-300 bg-white hover:border-yellow-300 hover:bg-neutral-50',
              ]"
            >
              Info
              <span
                :class="[
                  'ml-2 transition-transform duration-300',
                  open ? 'rotate-180' : '',
                  isInDropdown ? 'text-black' : 'text-yellow-300',
                ]"
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
            </MenuButton>

            <transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <MenuItems class="mt-2 w-full flex flex-col space-y-2 px-1">
                <RouterLink
                  v-for="item in userNavigationDropDown"
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
                  {{ item.name }}
                </RouterLink>
              </MenuItems>
            </transition>
          </Menu>
        </div>

        <div class="border-t border-neutral-200 pt-4 pb-3">
          <div class="flex flex-col items-center mt-3 space-y-1 px-2">
            <RouterLink
              v-for="item in userNavigation"
              :key="item.name"
              :to="item.to"
              :class="[
                $route.name === item.to.name
                  ? 'bg-neutral-200 border-yellow-300 text-black'
                  : 'text-black border border-neutral-100 bg-neutral-100 hover:border-yellow-300 hover:bg-neutral-50',
                'rounded-xl w-full text-center px-4 py-2.5 text-sm font-medium',
              ]"
              :aria-current="$route.name === item.to.name ? 'page' : undefined"
              >{{ item.name }}</RouterLink
            >
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
    <RouterView />
    <GuestFooter />
  </div>
</template>

<style scoped></style>
