<script setup>
import { ref, computed, onMounted } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";
import SidebarLink from "@/Components/SidebarLink.vue";
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

const showingNavigationDropdown = ref(false);
let currentRoute = ref("");

const routeTitle = (route) => {
    if (route === 'admindash') {
    return 'Dashboard'
  } else if (route === 'students/create') {
    return 'Student Create'
  }else if (route === 'newstudents') {
    return 'New Students'
  } else if (route === 'schools/create') {
    return 'Schools Create'
  }else if (route === 'coordinators/create') {
    return 'Coordinators Create'
  }else if (route.match(/^schools\/\d+/)) {
  const userId = route.match(/^schools\/(\d+)/)[1];
  return `Schools Info`;
}else if (route.match(/^offcampus\/\d+/)) {
  const userId = route.match(/^offcampus\/(\d+)/)[1];
  return `View Recommendation`;
}else if (route.match(/^students\/\d+\/edit$/)) {
    const userId = route.match(/^students\/(\d+)\/edit$/)[1]
    return `Edit Profile`
  }else if (route.match(/^coordinators\/\d+\/edit$/)) {
    const userId = route.match(/^coordinators\/(\d+)\/edit$/)[1]
    return `Edit Profile`
  }else if (route.match(/^newstudents\/\d+\/edit$/)) {
    const userId = route.match(/^newstudents\/(\d+)\/edit$/)[1]
    return `Approval`
  }else {
    const routeLabel = route?.toString().charAt(0).toUpperCase() + route.substring(1)
    return routeLabel 
  }
};

onMounted(() => {
  currentRoute.value = routeTitle(window.location.pathname.substring(1));
});

const isApplicationDropdownOpen = ref(false);

const toggleStudentsDropdown = () => {
  isStudentsDropdownOpen.value = !isStudentsDropdownOpen.value;
};

const toggleApplicationsDropdown = () => {
  isApplicationDropdownOpen.value = !isApplicationDropdownOpen.value;
};
</script>

<template>
  <!-- <aside
      class="ml-[-100%] fixed z-10 top-0 pb-3 px-6 w-full flex flex-col justify-between h-screen bg-blue transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]"
    > -->


   <div class="w-full h-full bg-darkWhite h-screen">
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform -translate-x-full sm:translate-x-0 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]" aria-label="Sidebar">
   <div class="h-full px-3 py-4 bg-blue dark:bg-gray-800">
      <a class="flex items-center pl-2.5 mt-2 ml-5">
         <!-- <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 mr-3 sm:h-7" alt="Flowbite Logo" /> -->
         <span class="self-center text-3xl font-semibold whitespace-nowrap text-white">PracTEACH</span>
      </a>
        

        

        <ul class="space-y-2 tracking-wide mt-10">
          <li>
            <SidebarLink
              :href="route('admindashbsed.index')"
              :active="route().current('admindashbsed.index')"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
              <span
                class="ml-4"
                >Dashboard</span
              >
            </SidebarLink>
          </li>

          <li>
            <!-- <SidebarLink
              :href="route('recommender.index')"
              :active="route().current('recommender.index')"
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
                  d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in-out"
                >Recommender</span
              >
            </SidebarLink> -->
          </li>

          <li>
                 <SidebarLink 
                 :href="route('offcampusbsed.index')" 
                :active="route().current('offcampusbsed.index')">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path class="group-hover:text-blue-600" stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>


                    <span class="ml-4">Off-Campus</span>
                </SidebarLink>
            </li>
          <li>
            <SidebarLink
              :href="route('schoolsbsed.index')"
              :active="route().current('schoolsbsed.index')"
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
                  d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in-out"
                >Host Training Establishments</span
              >
            </SidebarLink>
          </li>

          <li>
            <a
              @click.prevent="toggleApplicationsDropdown"
              class="flex ml-4 space-x-4 w-full py-2 font-semibold text-white hover:text-yellow-200 text-sm focus:outline-none "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6 ml-3 text-white"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75"
                />
              </svg>

              <span
                class="text-white"
                >Applications</span
              >
              <svg
                v-if="isApplicationDropdownOpen"
                class="w-5 h-5 ml-2 -mr-1 transform -rotate-180"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 15l7-7 7 7"
                />
              </svg>
              <svg
                v-else
                class="w-5 h-5 ml-2 -mr-1 transform"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 9l-7 7-7-7"
                />
              </svg>
            </a>
            <transition name="fade">
              <ul
                v-if="isApplicationDropdownOpen"
                class="space-y-2 tracking-wide mt-2 ml-10"
              >
                <li>
                  <SidebarLink
                    @click="preventDropdownClose"
                    :href="route('applicationsbsed.inCampusApplication')"
                    :active="
                      route().current('applicationsbsed.inCampusApplication')
                    "
                  >
                    In-campus Application
                  </SidebarLink>
                    </li>

             
                <li>
                  <SidebarLink
                    @click="preventDropdownClose"
                    :href="route('applicationsbsed.offCampusApplication')"
                    :active="
                      route().current('applicationsbsed.offCampusApplication')
                    "
                  >
                    Off-Campus Application
                  </SidebarLink>
                </li>
              </ul>
            </transition>
          </li>

          <li>
            <SidebarLink
              :href="route('studentsbsed.index')"
              :active="route().current('studentsbsed.index')"
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
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in-out"
                >Interns</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('newstudentsbsed.index')"
              :active="route().current('newstudents.index')"
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
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in-out"
                >New Interns</span
              >
            </SidebarLink>
          </li>

          <li>
            <SidebarLink
              :href="route('coordinatorsbsed.index')"
              :active="route().current('coordinatorsbsed.index')"
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
                  d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"
                />
              </svg>

              <span
                class="-mr-1 font-medium group-hover:text-blue-600 transition duration-500 ease-in-out"
                >Coordinators</span
              >
            </SidebarLink>
          </li>
        </ul>
        
      </div>

      
    </aside>
    <div class="ml-auto mb-6 lg:w-[75%] xl:w-[80%] 2xl:w-[85%]">
      <div
        class="fixed z-10 w-full bg-blue border-b-4 border-gold lg:py-2.5 lg:w-[85%] xl:w-[80%] 2xl:w-[85%]"
      >
        <div
          class="pr-6 flex items-center justify-between space-x-4 2xl:container"
        >
         <div hidden class="md:block">
             
            </div>
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
      <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>
          <div class="flex space-x-4">
            <!--search bar -->
            
            <!--/search bar -->
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

           

           <span class="hidden text-right lg:block flex items-center mt-1">
            <span class="block text-sm font-medium text-white dark:text-white">{{ $page.props.auth.user.full_name }}</span>
            <span class="block text-xs font-medium text-gold">BSED, Internship Coordinator</span>
            
          </span>
           <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm font-medium text-white rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:mr-0 focus:outline-none transition duration-200 ease-in-out" type="button">
    <span class="sr-only">Open user menu</span>
     <img class="w-10 h-10 m-auto border-2 border-gold rounded-full object-cover lg:w-12 lg:h-12" src="@/Assets/maamtan.jpg" alt="user photo">
    <svg class="w-5 h-5 mx-1.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
</button>

<!-- Dropdown menu -->
<div id="dropdownAvatarName" class=" z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
      <li>
        <a href="#" class="block px-4 py-2 hover:text-gold">Profile</a>
      </li>
      <li>
        <Link :href="route('logout')" method="post" as="button" class="block px-4 py-2  hover:text-gold focus:outline-none">Log out</Link>
      </li>
    </ul>
</div>
          </div>
        </div>
      </div>

      <div class="px-6 pt-6 2xl:container">
        <slot />
      </div>
    </div>
  </div>
</template>