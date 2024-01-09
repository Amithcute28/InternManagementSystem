<script setup>
import { ref, computed, onMounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import SidebarLink from "@/Components/SidebarLink.vue";

import { reactive } from "vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();
const user = reactive({ ...page.props.auth.user });

const props = defineProps({
  application_forms: {
    type: Object,
  },
});

console.log(user.profile);

const showingNavigationDropdown = ref(false);

let currentRoute = ref("");

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const routeTitle = (route) => {
  const parts = route.split("/").filter(Boolean);

  if (parts[0] === "user" && parts.length === 1) {
    return "Dashboard";
  } else if (parts[0] === "user" && parts.length === 3 && parts[2] === "edit") {
    const userId = parts[1];
    return `Edit Profile`;
  } else {
    return (
      parts[0]?.charAt(0).toUpperCase() + parts[0].substring(1) || "Unknown"
    );
  }
};

onMounted(() => {
  currentRoute.value = routeTitle(window.location.pathname.substring(1));
});
</script>

<template>
  <div class="w-full h-full bg-darkWhite h-screen">
    <aside
      id="logo-sidebar"
      class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full sm:translate-x-0 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]"
      aria-label="Sidebar"
    >
      <div class="h-full px-3 py-4 bg-blue dark:bg-gray-800">
        <div>
          <a
            href="#home"
            class="text-white text-lg font-extrabold flex items-center justify-center py-5 px-2"
          >
            <img src="@/Assets/logo.png" class="w-12 h-12 mr-3" />
            <span>Prac<span class="text-yellow-400">Teach.</span></span>
          </a>
        </div>

        <div class="-mx-6 px-6 py-4">
          <a href="#" title="home"> </a>
        </div>

        <div class="mt-0 text-center">
          <!-- <p>{{ user.profile }}</p>
          <p class="text-white"> {{ user.full_name }}</p> -->
          <div class="flex justify-center">
            <img
              :src="`/storage/${user.profile}`"
              alt=""
              class="h-16 w-16 rounded-full border-2 border-gold object-cover"
            />
          </div>

          <h5 class="hidden mt-4 text-xl font-semibold text-white lg:block">
            {{ user.full_name }}
          </h5>
          <span class="hidden text-gold lg:block">Student</span>
        </div>

        <ul class="space-y-2 tracking-wide mt-8">
          <li>
            <SidebarLink
              :href="route('user.index')"
              :active="route().current('user.index')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-300 ease-in"
                >Dashboard</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('student-calendar.index')"
              :active="route().current('student-calender.index')"
            >
              <svg
                class="w-5 h-5 text-white dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 20"
              >
                <path
                  fill="currentColor"
                  d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in"
                >Calendar</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('requests.index')"
              :active="route().current('requests.index')"
            >
              <svg
                class="w-5 h-5 text-white dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 20 16"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m19 2-8.4 7.05a1 1 0 0 1-1.2 0L1 2m18 0a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1m18 0v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in"
                >Request</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('application.index')"
              :active="route().current('application.index')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  class="group-hover:text-blue-600"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in"
                >Application</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('attendance.index')"
              :active="route().current('attendance.index')"
            >
              <svg
                class="w-5 h-5 text-white dark:text-white"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 16 20"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 1v4a1 1 0 0 1-1 1H1m4 6 2 2 4-4m4-8v16a.97.97 0 0 1-.933 1H1.933A.97.97 0 0 1 1 18V5.828a2 2 0 0 1 .586-1.414l2.828-2.828A2 2 0 0 1 5.828 1h8.239A.97.97 0 0 1 15 2Z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in"
                >My Attendance</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('status.index')"
              :active="route().current('status.index')"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  class="group-hover:text-blue-600"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in"
                >Status</span
              >
            </SidebarLink>
          </li>
        </ul>

        <button
          class="ml-4 mt-20 px-4 py-3 flex items-center space-x-4 rounded-md text-white group hover:text-amber-500"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
            />
          </svg>
          <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="group-hover:text-amber-500 font-bold"
            >Logout</Link
          >
        </button>
      </div>
    </aside>
    <div class="ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%]">
      <div
        class="fixed z-10 w-full bg-blue border-b-4 border-gold lg:py-2.5 lg:w-[85%] xl:w-[80%] 2xl:w-[85%]"
      >
        <div
          class="px-6 flex items-center justify-between space-x-4 2xl:container"
        >
          <h5 hidden class="text-2xl text-white font-medium lg:block">
            {{ currentRoute }}
          </h5>
          <button
            data-drawer-target="logo-sidebar"
            data-drawer-toggle="logo-sidebar"
            aria-controls="logo-sidebar"
            type="button"
            class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
          >
            <span class="sr-only">Open sidebar</span>
            <svg
              class="w-6 h-6"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
              ></path>
            </svg>
          </button>
        </div>
      </div>

      <div class="px-6 pt-6 2xl:container">
        <slot />
      </div>
    </div>
  </div>
</template>