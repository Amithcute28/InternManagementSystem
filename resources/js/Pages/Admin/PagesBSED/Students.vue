<script setup>
import AdminLayoutBSED from "@/Layouts/AdminLayoutBSED.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const offCampus = (form) => {
  return (
    form.eslip &&
    form.psa &&
    form.pros &&
    form.applicationF &&
    form.medical &&
    form.parent &&
    form.twobytwo && 
    form.eval_form && 
    form.is_off_campus === 1
  );
};

const inCampus = (form) => {
  return (
    form.eslip &&
    form.psa &&
    form.pros &&
    form.applicationF &&
    form.medical &&
    form.parent &&
    form.twobytwo && 
    form.eval_form && 
    form.is_off_campus === 0
  );
};

const props = defineProps({
  files: {
    type: Array,
    required: true,
  },
  approved: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  student_id: "",
  password: "",
  password_confirmation: "",
  program: "",
  full_name: "",
  email: "",
  birthday: "",
  gender: "",
  relationship: "",
  nationality: "",
  contact_number: "",
  home_address: "",
  guardian_name: "",
  guardian_contact: "",
  terms: false,
});

// const submit = async () => {
//   form.processing = true;

//   // Submit the application form
//   await form.post("/application");
//   await form.put("/application", {
//     _method: "put",
//   });

//   // Submit the student form
//   await form.post(route("students.store"), {
//     onFinish: () => form.reset("password", "password_confirmation"),
//   });

//   form.processing = false;
//   form.reset();
// };

const submit = () => {
        form.post(route('students.store'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
  <Head title="Students" />

  <AdminLayoutBSED>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <h1></h1>
         <button onclick="document.getElementById('myModal').showModal()" id="btn" class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">New Intern</button>
        <!-- <Link
          :href="route('studentsbsed.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        > -->
      </div>
      <!-- <div class="mt-6">
        <Table>
          <template #header>
            <TableRow>
              <th scope="col" class="p-4 bg-white">
                <div class="flex items-center bg-white">
                  <input
                    id="checkbox-all-search"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label for="checkbox-all-search" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </th>
              <TableHeaderCell>ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Program</TableHeaderCell>
              <TableHeaderCell>Status</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </template>

          <template #default>
            <TableRow
              class="overflow-auto"
              v-for="student in students"
              :key="student.id"
            >
              <td class="w-4 p-4 bg-white">
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
              </td>

              <TableDataCell>{{ student.student_id }}</TableDataCell>
              <TableDataCell
                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
              >
                <img
                  class="w-10 h-10 rounded-full"
                  src="@/Assets/profile.jpg"
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
              <TableDataCell>
                <div class="flex items-center">
                  <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                  Online
                </div>
              </TableDataCell>
              <TableDataCell class="space-x-4">
                <Link
                  :href="route('students.edit', student.id)"
                  class="text-green-400 hover:text-green-600"
                  >Edit</Link
                >
                <Link
                  :href="route('students.destroy', student.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >
              </TableDataCell>
            </TableRow>
          </template>
        </Table> -->
    </div>
    <div class="mt-6">
      <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell class="whitespace-nowrap"
              >Student ID</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap">Name</TableHeaderCell>
            <TableHeaderCell class="whitespace-nowrap">Program</TableHeaderCell>
            <TableHeaderCell class="whitespace-nowrap">Status</TableHeaderCell>
            <!-- <TableHeaderCell class="whitespace-nowrap"
              >Entrance Slip</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >PSA LiveBirth</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Prospectus</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Application Form</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Medical Certificate</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Parent's Permit</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap">2x2 ID</TableHeaderCell> -->
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow v-for="form in approved" :key="form.id">
            <TableDataCell>{{ form.student_id }}</TableDataCell>
            <TableDataCell class="flex items-center gap-3">
              <div class="relative h-10 w-10">
                <img
                :src="`storage/${form.profile}`"
                  class="h-full w-full rounded-full object-cover object-center"
                  alt=""
                />
                <span
                  class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"
                ></span>
              </div>
              {{ form.full_name }}</TableDataCell>
            <TableDataCell>{{ form.program }}</TableDataCell>
             <TableDataCell>
              <template v-if="offCampus(form)">
                 <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-violet-500 mr-2"></div> Off-Campus
                  </div>
              </template>

              <template v-else-if="inCampus(form)">
              <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 mr-2"></div> In-Campus
                  </div>
              </template>
              
              <template v-else>
                <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-blue-500 mr-2"></div> Processing In-Campus
                  </div>
              </template></TableDataCell>

            <TableDataCell class="space-x-4">
                <Link
                  :href="route('studentsbsed.edit', form.id)"
                  class="text-green-400 hover:text-green-600"
                  >Edit</Link
                >
                <Link
                  :href="route('studentsbsed.destroy', form.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >
              </TableDataCell>

            <!-- <TableDataCell
              ><div class="flex item-center">
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
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                    />
                  </svg>
                </div>
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
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                    />
                  </svg>
                </div>
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
                </div></div
            ></TableDataCell> -->
          </TableRow>
        </template>
      </Table>
    </div>

    <dialog id="myModal" class="h-auto w-11/12 md:w-1/2 p-5  bg-white rounded-md ">
        
   <div class="flex flex-col w-full h-auto ">
        <!-- Header -->
        <div class="flex w-full h-auto justify-between items-center">
          <p class="mt-2 text-lg">New Intern</p>
          <div onclick="document.getElementById('myModal').close();" class="flex w-1/12 h-auto justify-center cursor-pointer mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
          <!--Header End-->
        </div>
          <!-- Modal Content-->
           <div class="bg-white pb-10 px-10 rounded-xl shadow-xl mt-16">
      <div
        class="flex items-center justify-between space-x-2 ml-3 font-semibold text-gray-900 leading-8"
      >
      </div>
      <div class="text-gray-700">
         <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
          <div class="grid md:grid-cols-2 text-sm md:gap-x-4">
            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="student_id"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.student_id"
                required
                autofocus
                autocomplete="student_id"
              />
              <label
                for="student_id"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Student ID</label
              >
              <InputError class="mt-2" :message="form.errors.student_id" />
            </div>

            <div class="grid md:grid-cols-2 md:gap-4">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="program"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.program"
                  required
                  autofocus
                  autocomplete="program"
                />
                <label
                  for="program"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Program</label
                >
                <InputError class="mt-2" :message="form.errors.program" />
              </div>
              
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="full_name"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.full_name"
                required
                autofocus
                autocomplete="full_name"
              />
              <label
                for="full_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Full Name</label
              >
              <InputError class="mt-2" :message="form.errors.full_name" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="email"
                id="email"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.email"
                required
                autofocus
                autocomplete="email"
              />
              <label
                for="email"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Email Address</label
              >
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="password"
                id="password"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.password"
                required
                autofocus
                autocomplete="password"
              />
              <label
                for="password"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Password</label
              >
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="password"
                id="password_confirmation"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.password_confirmation"
                required
                autofocus
                autocomplete="password_confirmation"
              />
              <label
                for="password_confirmation"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Confirm Password</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
              />
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="birthday"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.birthday"
                  required
                  autofocus
                  autocomplete="birthday"
                />
                <label
                  for="birthday"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Birthday</label
                >
                <InputError class="mt-2" :message="form.errors.birthday" />
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="gender"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.gender"
                  required
                  autofocus
                  autocomplete="gender"
                />
                <label
                  for="gender"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Gender</label
                >
                <InputError class="mt-2" :message="form.errors.gender" />
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="relationship"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.relationship"
                  required
                  autofocus
                  autocomplete="relationship"
                />
                <label
                  for="relationship"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Relationship</label
                >
                <InputError class="mt-2" :message="form.errors.relationship" />
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="nationality"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.nationality"
                  required
                  autofocus
                  autocomplete="nationality"
                />
                <label
                  for="nationality"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Nationality</label
                >
                <InputError class="mt-2" :message="form.errors.nationality" />
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="contact_number"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.contact_number"
                  required
                  autofocus
                  autocomplete="contact_number"
                />
                <label
                  for="contact_number"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Contact Number</label
                >
                <InputError
                  class="mt-2"
                  :message="form.errors.contact_number"
                />
              </div>
              
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="home_address"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.home_address"
                required
                autofocus
                autocomplete="home_address"
              />
              <label
                for="home_address"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Home Address</label
              >
              <InputError class="mt-2" :message="form.errors.home_address" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_name"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.guardian_name"
                required
                autofocus
                autocomplete="guardian_name"
              />
              <label
                for="guardian_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Name</label
              >
              <InputError class="mt-2" :message="form.errors.guardian_name" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_contact"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.guardian_contact"
                required
                autofocus
                autocomplete="guardian_contact"
              />
              <label
                for="guardian_contact"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Contact Number</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.guardian_contact"
              />
            </div>
          </div>

          
        </form>
      </div>
      </div>
           
          <button
            type="submit"
            class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3"
          >
            Create student
          </button>
          <!-- End of Modal Content-->
          
          
          
        </div>
</dialog>
  </AdminLayoutBSED>
</template>

<style>
  dialog[open] {
  animation: appear .15s cubic-bezier(0, 1.8, 1, 1.8);
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