

<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";

import { onMounted } from "vue";
import { initFlowbite } from "flowbite";


onMounted(() => {
  initFlowbite();
});

defineProps(["users"]);


</script>

<template>
  <Head title="Student Profile" />

  <UserLayout>
    <div class="bg-gray-100 mt-16">
      <div class="w-full text-white bg-main-color">
        <div
          x-data="{ open: false }"
          class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8"
        ></div>
      </div>
  

      <div class="container mx-auto bg-white">
        <div class="md:flex no-wrap md:-mx-2">

          <div class="w-full mx-2 h-64">
      
            <div class="bg-white p-3 rounded-xl shadow-md">
              <div
                class="flex items-center space-x-2 ml-3 font-semibold text-gray-900 leading-8"
              >
                <span clas="text-green-500">
                  <svg
                    class="h-5"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    />
                  </svg>
                </span>
                <span class="tracking-wide">About</span>
              </div>
              <div class="text-gray-700">
                <div class="grid md:grid-cols-2 text-sm">
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Full name</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.full_name }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Student ID</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.student_id }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Program</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.program }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Email</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.email }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Contact Number</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.contact_number }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Birthday</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.birthday }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Gender</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.gender }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Relationship</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.relationship }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Nationality</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.nationality }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Home Address</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.home_address }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">Guardian Name</div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.guardian_name }}
                    </div>
                  </div>
                  <div class="grid grid-cols-2">
                    <div class="px-4 py-2 font-semibold">
                      Guardian Contact Number
                    </div>
                    <div class="px-4 py-2">
                      {{ $page.props.auth.user.guardian_contact }}
                    </div>
                  </div>
                </div>
              </div>

              <Link
                v-for="user in users"
                :key="user.id"
                :href="route('user.edit', user.id)"
                class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-gold hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                >Edit Information</Link
              >
            </div>
            
            <div class="my-4"></div>
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>

<style>
:root {
  --main-color: #4a76a8;
}

.bg-main-color {
  background-color: var(--main-color);
}

.text-main-color {
  color: var(--main-color);
}

.border-main-color {
  border-color: var(--main-color);
}
</style>