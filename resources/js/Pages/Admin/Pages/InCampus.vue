<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const props = defineProps({
  students: Array,
  institution: Array,
  interns: Array,
  filters: Array,
});

const search = ref(props.filters.search);
const perPage = ref(5);

watch(search, (value) => {
  router.get(
    "first-shift",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

function getTags() {
  router.get(
    "first-shift",
    { perPage: perPage.value },
    {
      preserveState: true,
      replace: true,
    }
  );
}

const totalInterns = props.interns.length;

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const applications = ref(null);

function openModal(student) {
  applications.value = student;
  document.getElementById("myModal").showModal();
}

const recommend = ref(null);

function openModalRecommend(student) {
  recommend.value = student;
  document.getElementById("myModalRecommend").showModal();
}

const confirmProceed = (id) => {
  const result = Swal.fire({
    title: "Confirm Second Shift",
    text: "Are you sure the practice teaching intern is ready for the second shift?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, proceed!",
  }).then((result) => {
    if (result.isConfirmed) {
      // If confirmed, proceed with the action
      router.put(route("first-shift.update", id));
    }
  });
};
</script>

<template>
  <Head title="First Shift" />

  <AdminLayout>
    <!-- <div class="mt-16 flex">

            <div class="w-full">
                <h1 class="text-xl font-bold mb-4">Students</h1>
                <div class="bg-white shadow-md rounded my-6">
                    <table class="w-full table-auto"> 
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Program</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Academic Performance</th>
                                <th class="py-3 px-4 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="student in students" :key="student.id" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4">{{ student.full_name }}</td>
                                <td class="py-3 px-4">{{ student.program }}</td>
                                <td class="py-3 px-4">{{ student.email }}</td>
                                <td class="py-3 px-4">{{ student.academic_performance }}</td>
                                <td class="py-3 px-4">
                                    <Link :href="route('offcampus.show', { id: student.id })" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</Link>
                                    <ul v-if="student.recommended_institutions.length > 0">
                                        <li v-for="institution in student.recommended_institutions" :key="institution.id">
                                            {{ institution.name }} - {{ institution.required_academic_performance }}
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

    <div class="mt-16">
      <div class="flex justify-between">
        <p class="text-2xl font-semibold ml-4">First Shift</p>

        <!-- <Link
          :href="route('students.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        > -->
      </div>

      <div
        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4"
      >
        <div class="flex items-center flex-1 space-x-4">
          <h5>
            <span class="text-gray-500">All First Shift Interns: </span>
            <span class="dark:text-white">{{ totalInterns }}</span>
          </h5>
        </div>
        <div
          class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3"
        >
          <label for="table-search" class="sr-only">Search</label>
          <div class="relative">
            <div
              class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
            >
              <svg
                class="w-5 h-5 text-gray-500 dark:text-gray-400"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </div>
            <input
              v-model="search"
              type="text"
              id="table-search-users"
              class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-72 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Search for interns"
            />
          </div>

          <div>
            <select
              v-model="perPage"
              @change="getTags"
              class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:ring-0 text-sm"
            >
              <option value="5">5 Per Page</option>
              <option value="10">10 Per Page</option>
              <option value="15">15 Per Page</option>
            </select>
          </div>
          <!-- <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                      <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                      </svg>
                      Update stocks 1/250
                  </button>
                  <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                      <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                      </svg>
                      Export
                  </button> -->
        </div>
      </div>
      <div class="">
        <Table>
          <template #header>
            <TableRow>
              <!-- <th scope="col" class="p-4">
                <div class="flex items-center">
                  <input
                    id="checkbox-all-search"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label for="checkbox-all-search" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </th> -->
              <TableHeaderCell>Student ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Program</TableHeaderCell>
              <TableHeaderCell>School</TableHeaderCell>
              <TableHeaderCell>Application</TableHeaderCell>
              <TableHeaderCell>Attendance</TableHeaderCell>
              <!-- <TableHeaderCell>Evaluation Form</TableHeaderCell> -->
              <TableHeaderCell>Status</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </template>

          <template #default>
            <TableRow
              class="overflow-auto"
              v-for="student in students.data"
              :key="student.id"
            >
              <!-- <td class="w-4 p-4 bg-white">
                <div class="flex items-center">
                  <input
                    id="checkbox-table-search-1"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label for="checkbox-table-search-1" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </td> -->

              <TableDataCell>{{ student.student_id }}</TableDataCell>
              <TableDataCell
                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
              >
                <img
                  class="w-10 h-10 rounded-full"
                  :src="`storage/${student.profile}`"
                  alt="Jese image"
                />
                <div class="pl-3">
                  <div class="text-base font-semibold">
                    {{ student.full_name }}
                  </div>
                  <div class="font-normal text-gray-500">
                    {{ student.email }}
                  </div>
                </div>
              </TableDataCell>
              <TableDataCell>{{ student.program }}</TableDataCell>
              <TableDataCell>{{ student.student_school_name }}</TableDataCell>
              <TableDataCell>
                <button
                  @click="openModal(student)"
                  class="px-6 py-2 text-white bg-gold hover:bg-indigo-400 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                  View
                </button></TableDataCell
              >
              <TableDataCell class="space-x-4">
                <Link
                  :href="
                    route('offcampus-attendance.attendanceStudent', student.id)
                  "
                  class="text-green-400 hover:text-green-600"
                  >Check</Link
                >
                <!-- <button @click="openModalRecommend(student)" class="px-6 py-2  text-white bg-gold hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button> -->
              </TableDataCell>
              <!-- <TableDataCell
              ><a
                v-if="isImage(student.eval_form)"
                :href="student.psa"
                target="_blank"
              >
                <img
                  :src="student.eval_form"
                  style="max-width: 100%; max-height: 100px"
                  class="h-16 w-16"
                />
              </a>
              <a
                v-else-if="isPdf(student.eval_form)"
                :href="studenteval_form"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(student.eval_form)"
                :href="student.eval_form"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="student.eval_form"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell> -->
              <TableDataCell class="space-x-4">
                <Link
                  :href="route('first-shift.show', student.id)"
                  class="text-green-400 hover:text-green-600"
                  >View</Link
                >
                <!-- <button @click="openModalRecommend(student)" class="px-6 py-2  text-white bg-gold hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button> -->
              </TableDataCell>
              <TableDataCell
                ><div class="flex item-center space-x-2">
                  <!-- <Link :href="route('stes-interns.proceed', form.id)" method="PUT" as="button" class="text-green-400 hover:text-red-600">R</Link> -->

                  <Link
                    :href="route('first-shift.update', student.id)"
                    method="PUT"
                    as="button"
                    class="text-grey-300 hover:text-yellow-300"
                  >
                    <font-awesome-icon
                      :icon="['far', 'square-caret-right']"
                      class="fa-lg outline-none"
                  /></Link>
                  <!-- <button
                    @click="confirmRecommendation(form.id)"
                    class="w-5 h-5 text-green-400 transform hover:text-red-600 hover:scale-110 focus:outline-none active:outline-none"
                  >
                    <font-awesome-icon
                      :icon="['far', 'square-caret-right']"
                      class="px-2 fa-lg outline-none"
                    />
                  </button> -->

                  <svg
                    @click="openModalEvalForm(student)"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-5 h-5 transform hover:text-yellow-300 hover:scale-110"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>

                  <div
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                  </div> 
                </div></TableDataCell
              >
            </TableRow>
          </template>
        </Table>
        <div class="m-2 p-2">
          <Pagination :links="students.links" />
        </div>
      </div>
    </div>

    <dialog id="myModal" class="p-5 bg-darkWhite rounded-md">
      <div class="flex w-full h-auto justify-between items-center">
        <div
          class="flex h-auto py-3 justify-center items-center text-2xl font-bold"
        >
          In-Campus Application
        </div>
        <div
          onclick="document.getElementById('myModal').close();"
          class="flex w-1/12 h-auto justify-center cursor-pointer"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="#000000"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-x"
          >
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </div>
      </div>
      <div class="flex items-center flex-col p-10">
        <!-- main card -->

        <!-- headers content-->

        <!-- subscriptions -->
        <div class="grid grid-cols-12 gap-6" v-if="applications">
          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="text-lg leading-6 text-black mb-12 flex items-center"
                >Entrance Slip</label
              >
              <a
                v-if="isImage(applications.eslip)"
                :href="applications.eslip"
                target="_blank"
              >
                <img
                  :src="applications.eslip"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.eslip)"
                :href="applications.eslip"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.eslip)"
                :href="applications.eslip"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.eslip"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >PSA Livebirth</label
              >
              <a
                v-if="isImage(applications.psa)"
                :href="applications.psa"
                target="_blank"
              >
                <img
                  :src="applications.psa"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.psa)"
                :href="applications.psa"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.psa)"
                :href="applications.psa"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.psa"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >Prospectus</label
              >
              <a
                v-if="isImage(applications.pros)"
                :href="applications.pros"
                target="_blank"
              >
                <img
                  :src="applications.pros"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.pros)"
                :href="applications.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.pros)"
                :href="applications.pros"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.pros"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >Application Form</label
              >
              <a
                v-if="isImage(applications.applicationF)"
                :href="applications.applicationF"
                target="_blank"
              >
                <img
                  :src="applications.applicationF"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.applicationF)"
                :href="applications.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.applicationF)"
                :href="applications.applicationF"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.applicationF"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >Medical Certificate</label
              >
              <a
                v-if="isImage(applications.medical)"
                :href="applications.medical"
                target="_blank"
              >
                <img
                  :src="applications.medical"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.medical)"
                :href="applications.medical"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.medical)"
                :href="applications.medical"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.medical"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >Parent's Permit</label
              >
              <a
                v-if="isImage(applications.parent)"
                :href="applications.parent"
                target="_blank"
              >
                <img
                  :src="applications.parent"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.parent)"
                :href="applications.parent"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.parent)"
                :href="applications.paremt"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.parent"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-2"
                >2x2 ID</label
              >
              <a
                v-if="isImage(applications.twobytwo)"
                :href="applications.twobytwo"
                target="_blank"
                class=""
              >
                <img
                  :src="applications.twobytwo"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(applications.twobytwo)"
                :href="applications.twobytwo"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(applications.twobytwo)"
                :href="applications.twobytwo"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="applications.twobytwo"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </div>

            <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
          </div>
        </div>

        <div class="flex justify-center">
          <button class="mt-12 bg-gold text-white rounded-lg py-2"></button>
        </div>
      </div>
    </dialog>

    <dialog id="myModalRecommend" class="p-5 bg-darkWhite rounded-md">
      <div class="flex w-full h-auto justify-between items-center">
        <div
          class="flex h-auto py-3 justify-center items-center text-2xl font-bold"
        >
          In-Campus Application
        </div>
        <div
          onclick="document.getElementById('myModalRecommend').close();"
          class="flex w-1/12 h-auto justify-center cursor-pointer"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="#000000"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-x"
          >
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </div>
      </div>
      <div class="flex items-center flex-col p-10">
        <!-- main card -->

        <!-- headers content-->

        <!-- subscriptions -->
        <div class="container mx-auto bg-white mt-16" v-if="recommend">
          <div class="md:flex no-wrap md:-mx-2">
            <!-- Left Side -->

            <!-- Right Side -->
            <div class="w-full mx-2 h-64">
              <!-- Profile tab -->
              <!-- About Section -->
              <div class="bg-white p-3 rounded-xl shadow-md">
                <div></div>
                <Head>
                  <title>
                    Recommended Institutions for {{ recommend.full_name }}
                  </title>
                </Head>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                  <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                      <h1 class="text-2xl font-bold mb-4">
                        {{ recommend.full_name }}
                      </h1>

                      <div class="mb-4 grid md:grid-cols-2">
                        <p><strong>Program:</strong> {{ recommend.program }}</p>
                        <p><strong>Email:</strong> {{ recommend.email }}</p>
                        <p>
                          <strong>Academic Performance:</strong>
                          {{ recommend.academic_performance }}
                        </p>
                        <p><strong>Skills:</strong> {{ recommend.skills }}</p>
                      </div>

                      <h1 class="text-2xl font-bold mb-4">
                        Recommended Institution:
                      </h1>
                      <!-- <ul>
            <li v-for="institution in student.recommended_institutions" :key="institution.name" class="my-2">
              <div class="font-bold">{{ institution.name }}</div>
              <div class="text-gray-500">{{ institution.required_programs }}</div>
              <div class="text-gray-500">{{ institution.skills}}</div>
              <div class="text-gray-500">{{ institution.address }}</div>
              <div class="text-sm text-gray-500">Required Academic Performance: {{ institution.academic_performance }}</div>
              
            </li>
          </ul> -->

                      <section class="text-gray-800">
                        <div class="block rounded-lg shadow-lg bg-white">
                          <div class="flex flex-wrap">
                            <div
                              class="grow-0 shrink-0 basis-auto block w-full lg:flex lg:w-6/12 xl:w-4/12"
                            >
                              <div class="map-container-2 w-full">
                                <iframe
                                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1956.657715528662!2d125.00004053842936!3d11.238190528016471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3308772c87c4c367%3A0xa5e5c080ec6a88ef!2sLeyte%20Normal%20University!5e0!3m2!1sen!2sph!4v1683656352509!5m2!1sen!2sph"
                                  class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg"
                                  frameborder="0"
                                  allowfullscreen
                                ></iframe>
                              </div>
                            </div>
                            <div
                              class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 xl:w-8/12"
                            >
                              <div
                                class="bg-white p-3 flex items-center justify-between ml-6 mt-4 mb-4"
                              >
                                <div class="flex space-x-6 items-center">
                                  <img
                                    :src="recommend.school_logo"
                                    class="w-auto h-24 rounded-lg"
                                  />
                                  <div>
                                    <p class="font-semibold text-2xl">
                                      {{ recommend.name }}
                                    </p>
                                    <p
                                      class="font-semibold text-lg text-gray-400"
                                    >
                                      {{ recommend.address }}
                                    </p>
                                  </div>
                                </div>
                              </div>
                              <div
                                class="flex flex-col justify-center items-center"
                              >
                                <div
                                  class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3"
                                >
                                  <div
                                    class="grid grid-cols-2 gap-4 px-2 w-full"
                                  >
                                    <div
                                      class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none"
                                    >
                                      <p class="text-lg text-gray-600">
                                        Address
                                      </p>
                                      <p
                                        class="text-base font-medium text-navy-700 dark:text-white"
                                      >
                                        {{ recommend.address }}
                                      </p>
                                    </div>

                                    <div
                                      class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none"
                                    >
                                      <p class="text-lg text-gray-600">
                                        Requirements
                                      </p>
                                      <p
                                        class="text-base font-medium text-navy-700 dark:text-white"
                                      >
                                        {{ recommend.requirements }}
                                      </p>
                                    </div>

                                    <div
                                      class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none"
                                    >
                                      <p class="text-lg text-gray-600">
                                        Required Programs
                                      </p>
                                      <p
                                        class="text-base font-medium text-navy-700 dark:text-white"
                                      >
                                        {{ recommend.required_programs }}
                                      </p>
                                    </div>

                                    <div
                                      class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none"
                                    >
                                      <p class="text-lg text-gray-600">
                                        Required Skills
                                      </p>
                                      <p
                                        class="text-base font-medium text-navy-700 dark:text-white"
                                      >
                                        {{ recommend.skills }}
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </section>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of about section -->
          </div>
        </div>

        <div class="flex justify-center">
          <button class="mt-12 bg-gold text-white rounded-lg py-2"></button>
        </div>
      </div>
    </dialog>
  </AdminLayout>
</template>

<style>
dialog[open] {
  animation: appear 0.15s cubic-bezier(0, 1.8, 1, 1.8);
}

dialog::backdrop {
  background: linear-gradient(45deg, rgba(0, 0, 0, 0.5), rgba(54, 54, 54, 0.5));
  backdrop-filter: blur(3px);
}

@keyframes appear {
  from {
    opacity: 0;
    transform: translateX(-3rem);
  }

  to {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>