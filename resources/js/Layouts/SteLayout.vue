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

const showingNavigationDropdown = ref(false);

let currentRoute = ref("");

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const routeTitle = (route) => {
  const parts = route.split('/').filter(Boolean);

  if (parts[0] === "user" && parts.length === 1) {
    return "Dashboard";
  } else if (parts[0] === "user" && parts.length === 3 && parts[2] === "edit") {
    const userId = parts[1];
    return `Edit Profile`;
  } else {
    return parts[0]?.charAt(0).toUpperCase() + parts[0].substring(1) || "Unknown";
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

        <!-- <div class="mt-4 text-center">
         
          <div class="flex justify-center">
            <img
              :src="`storage/${user.profile}`"
              alt=""
              class="h-16 w-16 rounded-full border-2 border-gold object-cover"
            />
          </div>

          <h5 class="hidden mt-4 text-xl font-semibold text-white lg:block">
            {{ user.full_name }}
          </h5>
          <span class="hidden text-gold lg:block">Student</span>
        </div> -->

        <ul class="space-y-2 tracking-wide mt-8">
          <li>
            <SidebarLink
              :href="route('ste-dashboard.index')"
              :active="route().current('ste-dashboard.index')"
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
              :href="route('calendar.calendarSte')"
              :active="route().current('calendar.calendarSte')"
            >
             <svg class="w-5 h-5 text-white dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
    <path fill="currentColor" d="M6 1a1 1 0 0 0-2 0h2ZM4 4a1 1 0 0 0 2 0H4Zm7-3a1 1 0 1 0-2 0h2ZM9 4a1 1 0 1 0 2 0H9Zm7-3a1 1 0 1 0-2 0h2Zm-2 3a1 1 0 1 0 2 0h-2ZM1 6a1 1 0 0 0 0 2V6Zm18 2a1 1 0 1 0 0-2v2ZM5 11v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 11v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM10 15v-1H9v1h1Zm0 .01H9v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 15v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM15 11v-1h-1v1h1Zm0 .01h-1v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM5 15v-1H4v1h1Zm0 .01H4v1h1v-1Zm.01 0v1h1v-1h-1Zm0-.01h1v-1h-1v1ZM2 4h16V2H2v2Zm16 0h2a2 2 0 0 0-2-2v2Zm0 0v14h2V4h-2Zm0 14v2a2 2 0 0 0 2-2h-2Zm0 0H2v2h16v-2ZM2 18H0a2 2 0 0 0 2 2v-2Zm0 0V4H0v14h2ZM2 4V2a2 2 0 0 0-2 2h2Zm2-3v3h2V1H4Zm5 0v3h2V1H9Zm5 0v3h2V1h-2ZM1 8h18V6H1v2Zm3 3v.01h2V11H4Zm1 1.01h.01v-2H5v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H5v2h.01v-2ZM9 11v.01h2V11H9Zm1 1.01h.01v-2H10v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM9 15v.01h2V15H9Zm1 1.01h.01v-2H10v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H10v2h.01v-2ZM14 15v.01h2V15h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM14 11v.01h2V11h-2Zm1 1.01h.01v-2H15v2Zm1.01-1V11h-2v.01h2Zm-1-1.01H15v2h.01v-2ZM4 15v.01h2V15H4Zm1 1.01h.01v-2H5v2Zm1.01-1V15h-2v.01h2Zm-1-1.01H5v2h.01v-2Z"/>
  </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-300 ease-in"
                >Calendar</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('ste-attendance.attendanceSte')"
              :active="route().current('ste-attendance.attendanceSte')"
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
                  d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-300 ease-in"
                >Attendance</span
              >
            </SidebarLink>
          </li>

           <li>
            <SidebarLink
              :href="route('stes-interns.interns')"
              :active="route().current('stes-interns.interns')"
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
                  class="group-hover:text-blue-400"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-300 ease-in"
                >Interns</span
              >
            </SidebarLink>
          </li>

         


          

          

         

         
        </ul>

        <button
          class="ml-4 mt-36 px-4 py-3 flex items-center space-x-4 rounded-md text-white group hover:text-amber-500"
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

          <div class="flex space-x-4">
          
            <button
              aria-label="search"
              class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200 md:hidden"
            >
              <svg
                xmlns="http://ww50w3.org/2000/svg"
                class="w-4 mx-auto fill-current text-gray-600"
                viewBox="0 0 35.997 36.004"
              >
                <path
                  id="Icon_awesome-search"
                  data-name="search"
                  d="M35.508,31.127l-7.01-7.01a1.686,1.686,0,0,0-1.2-.492H26.156a14.618,14.618,0,1,0-2.531,2.531V27.3a1.686,1.686,0,0,0,.492,1.2l7.01,7.01a1.681,1.681,0,0,0,2.384,0l1.99-1.99a1.7,1.7,0,0,0,.007-2.391Zm-20.883-7.5a9,9,0,1,1,9-9A8.995,8.995,0,0,1,14.625,23.625Z"
                ></path>
              </svg>
            </button>
            <button
              aria-label="chat"
              class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 m-auto text-gray-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"
                />
              </svg>
            </button>
            <button
              aria-label="notification"
              class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 m-auto text-gray-600"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <div class="px-6 pt-6 2xl:container">
        <slot />
      </div>
    </div>
  </div>
</template>