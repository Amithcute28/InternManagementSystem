<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

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
</script>

<template>
  <Head title="Students" />

  <AdminLayout>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <h1></h1>
        <Link
          :href="route('students.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        >
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
            <TableHeaderCell class="whitespace-nowrap"
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
            <TableHeaderCell class="whitespace-nowrap">2x2 ID</TableHeaderCell>
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow v-for="form in approved" :key="form.id">
            <TableDataCell>{{ form.student_id }}</TableDataCell>
            <TableDataCell class="flex items-center gap-3">
              <div class="relative h-10 w-10">
                <img
                  class="h-full w-full rounded-full object-cover object-center"
                  src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                  alt=""
                />
                <span
                  class="absolute right-0 bottom-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"
                ></span>
              </div>
              {{ form.full_name }}</TableDataCell
            >
            <TableDataCell>{{ form.program }}</TableDataCell>
            <TableDataCell
              ><a v-if="isImage(form.eslip)" :href="form.psa" target="_blank">
                <img
                  :src="form.eslip"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.eslip)"
                :href="form.eslip"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.eslip)"
                :href="form.eslip"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.eslip"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a v-if="isImage(form.psa)" :href="form.psa" target="_blank">
                <img
                  :src="form.psa"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.psa)"
                :href="form.psa"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.psa)"
                :href="form.psa"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.psa"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </TableDataCell>

            <TableDataCell>
              <a v-if="isImage(form.pros)" :href="form.pros" target="_blank">
                <img
                  :src="form.pros"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.pros)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.pros)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.pros"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.applicationF)"
                :href="form.applicationF"
                target="_blank"
              >
                <img
                  :src="form.applicationF"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.applicationF)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.pros)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.pros"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.medical)"
                :href="form.medical"
                target="_blank"
              >
                <img
                  :src="form.medical"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.medical)"
                :href="form.medical"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.medical)"
                :href="form.medical"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.medical"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.parent)"
                :href="form.parent"
                target="_blank"
              >
                <img
                  :src="form.parent"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.parent)"
                :href="form.parent"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.parent)"
                :href="form.paremt"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.parent"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >

            <TableDataCell>
              <a
                v-if="isImage(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
              >
                <img
                  :src="form.twobytwo"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.twobytwo"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >

            <TableDataCell>Edit/Delete</TableDataCell>
          </TableRow>
        </template>
      </Table>
    </div>
  </AdminLayout>
</template>
