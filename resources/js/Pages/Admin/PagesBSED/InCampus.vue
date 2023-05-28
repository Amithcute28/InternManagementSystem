<script setup>
import AdminLayoutBSED from "@/Layouts/AdminLayoutBSED.vue";
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

  <AdminLayoutBSED>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <h1></h1>
        <Link
          :href="route('studentsbsed.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        >
      </div>
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
              >Requirements</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap">CBAR</TableHeaderCell>
            <TableHeaderCell class="whitespace-nowrap"
              >E-Portfolio</TableHeaderCell
            >

            <TableHeaderCell class="bg-purple-100 text-center">
              Evaluation Form
              <TableHeaderCell class="whitespace-nowrap"
                >Medical Certificate</TableHeaderCell
              >
              <TableHeaderCell class="whitespace-nowrap"
                >Dental Certificate</TableHeaderCell
              >
              <TableHeaderCell class="whitespace-nowrap"
                >Parent's Permit</TableHeaderCell
              >
            </TableHeaderCell>

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
            <TableDataCell></TableDataCell>
            <TableDataCell></TableDataCell>
            <TableDataCell></TableDataCell>
            <TableDataCell>
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
                  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                  >DOC FILE</a
                >
                <a
                  v-else
                  :href="form.eslip"
                  target="_blank"
                  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                  >MISSING</a
                ></TableDataCell
              >
              <TableDataCell></TableDataCell>
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
                  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                  >DOC FILE</a
                >
                <a
                  v-else
                  :href="form.psa"
                  target="_blank"
                  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                  >MISSING</a
                >
              </TableDataCell>

              <TableDataCell></TableDataCell>

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
                  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                  >DOC FILE</a
                >
                <a
                  v-else
                  :href="form.pros"
                  target="_blank"
                  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                  >MISSING</a
                ></TableDataCell
              >
            </TableDataCell>

            <TableDataCell
              ><div class="flex item-center justify-center">
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
            ></TableDataCell>
          </TableRow>
        </template>
      </Table>
    </div>
  </AdminLayoutBSED>
</template>
