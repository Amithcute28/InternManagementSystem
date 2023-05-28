<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";


 const { students,newstudents,schools,deployed } = defineProps({
        students: Array,
        newstudents: Array,
        schools: Array,
        deployed:Array,
    });

    const totalStudents = students.length;
    const totalNewStudents = newstudents.length;
    const totalSchools = schools.length;
    const totalDeployed = deployed.length;
</script>

const schools = [
        {
            
        },
    ];

    const totalSchools = schools.length;
<template>
  <Head title="Dashboard" />

  <AdminLayout>
    <div class="grid grid-cols-12 gap-6 mt-16">
      <a
        class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
        href="#"
      >
        <div class="p-5">
          <div class="flex justify-between">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-7 w-7 text-blue-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
              />
            </svg>
            <div
              class="bg-violet-500 rounded-full h-6 px-2 flex justify-items-center text-white font-semibold text-sm"
            >
              <span class="flex items-center">30%</span>
            </div>
          </div>
          <div class="ml-2 w-full flex-1">
            <div>
              <div class="mt-3 text-3xl font-bold leading-8">
                {{ totalStudents }}
              </div>

              <div class="mt-1 text-base text-gray-600">Interns</div>
            </div>
          </div>
        </div>
      </a>
      <a
        class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
        href="#"
      >
        <div class="p-5">
          <div class="flex justify-between">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-7 w-7 text-yellow-400"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
              />
            </svg>
            <div
              class="bg-red-500 rounded-full h-6 px-2 flex justify-items-center text-white font-semibold text-sm"
            >
              <span class="flex items-center">30%</span>
            </div>
          </div>
          <div class="ml-2 w-full flex-1">
            <div>
              <div class="mt-3 text-3xl font-bold leading-8">
                {{ totalSchools }}
              </div>

              <div class="mt-1 text-base text-gray-600">HTE</div>
            </div>
          </div>
        </div>
      </a>
      <a
        class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
        href="#"
      >
        <div class="p-5">
          <div class="flex justify-between">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-7 w-7 text-pink-600"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"
              />
            </svg>
            <div
              class="bg-yellow-500 rounded-full h-6 px-2 flex justify-items-center text-white font-semibold text-sm"
            >
              <span class="flex items-center">30%</span>
            </div>
          </div>
          <div class="ml-2 w-full flex-1">
            <div>
              <div class="mt-3 text-3xl font-bold leading-8">
                {{ totalNewStudents }}
              </div>

                                                    <div class="mt-1 text-base text-gray-600">New Interns</div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="transform  hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
                                        href="#">
                                        <div class="p-5">
                                            <div class="flex justify-between">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                                </svg>
                                                <div
                                                    class="bg-blue-500 rounded-full h-6 px-2 flex justify-items-center text-white font-semibold text-sm">
                                                    <span class="flex items-center">30%</span>
                                                </div>
                                            </div>
                                            <div class="ml-2 w-full flex-1">
                                                <div>
                                                    <div class="mt-3 text-3xl font-bold leading-8">{{ totalDeployed }}</div>

              <div class="mt-1 text-base text-gray-600">Deployed</div>
            </div>
          </div>
        </div>
      </a>
    </div>

                                

        <div class="px-6 pt-6 2xl:container">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div class="md:col-span-2 lg:col-span-1 transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover: shadow-2x1" >
                <div class="h-full py-8 px-6 space-y-6 bg-white p-4 shadow-md rounded-lg">
                   
                  
                </div>
            </div>
            <div>
                <div class="h-full py-8 px-6 space-y-6 bg-white p-4 shadow-md rounded-lg transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover: shadow-2x1">

                 </div>   
            </div>
            <div>
                <div class="h-full py-8 px-6 space-y-6 bg-white p-4 shadow-lg rounded-lg transform transition-all hover:-translate-y-2 duration-300 shadow-lg hover:shadow-2x1 ">
                 
                   
                  
                </div>
            </div>
        </div>
    </div>
  </AdminLayout>
</template>
