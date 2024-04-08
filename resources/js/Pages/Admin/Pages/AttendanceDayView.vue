<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import FlexButton from "@/Components/FlexButton.vue";
import AttendanceTabs from "@/Components/Tabs/AttendanceTabs.vue";

import Swal from "sweetalert2";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Card from "@/Components/Card.vue";
import TrashIcon from "@/Components/Icons/TrashIcon.vue";
import {__} from "@/Composables/useTranslations.js";
import Table from "@/Components/Table/Table.vue";
import TableBodyHeader from "@/Components/Table/TableBodyHeader.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import {attendance_types} from "@/Composables/useAttendanceTypes.js";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    attendanceList: Object,
    day: String,
    filters: Array,

});

const search = ref(props.filters.search);
const perPage = ref(5);

watch(search, (value) => {
  router.get(
    "attendances.show",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

function getTags() {
  router.get(
    "attendances.show",
    { perPage: perPage.value },
    {
      preserveState: true,
      replace: true,
    }
  );
}

const destroy = () => {
    Swal.fire({
        title: "Are you sure? You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33',
    }).then((result) => {
        if (result.isConfirmed) {
            useForm({}).delete(route('attendance.destroy', { date: props.day }), {
                preserveScroll: true,
                onError: () => {
                    Swal.fire('Error Deleting Attendance', '', 'error');
                },
                onSuccess: () => {
                    Swal.fire('Attendance Removed!', '', 'success');
                },
            });
        }
    });
};



</script>

<template>
    <Head :title="('Attendance View')"/>
    <AdminLayout>
        <template #tabs>
            <AttendanceTabs />
        </template>
        <div class="py-8 mt-10">
            
                    <h1 class="text-2xl font-semibold ml-4 mb-4" v-text="'Attendance List for ' + day"></h1>
                    <div class="flex justify-between items-center pb-4 gap-4">
                        <div></div>

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
        </div>
                        <!-- <div class="flex justify-center items-center inline">
                            <FlexButton :href="route('attendance.create')" :text="('Retake/Update Attendance')">
                                <TrashIcon/>
                            </FlexButton>
                        </div> -->
                        <!-- <form @submit.prevent="destroy" class="flex justify-center items-center ">
                            <PrimaryButton class="bg-red-600 hover:bg-red-700 focus:bg-red-500 active:bg-red-900" >
                                <TrashIcon/>
                                {{('Delete Day Attendance')}}
                            </PrimaryButton>
                        </form> -->
                    </div>

                    <Table :links="attendanceList.links" :showingNumber="attendanceList.data.length"
                           :totalNumber="attendanceList.total">
                        <template #Head>
                            <TableHead>{{('ID')}}</TableHead>
                            <TableHead>{{('Student')}}</TableHead>
                            <TableHead>{{('School')}}</TableHead>
                            <TableHead>{{('Status')}}</TableHead>
                            <TableHead>{{('Time In')}}</TableHead>
                            <TableHead>{{('Time out')}}</TableHead>
                            <TableHead>{{('Notes')}}</TableHead>
                            <TableHead>{{('Journal')}}</TableHead>
                        </template>

                        <!--Iterate Here-->
                        <template #Body>
                            <TableRow v-for="attendance in attendanceList.data" :key="attendance.id">
                                <TableBodyHeader>{{ attendance.student_id }}</TableBodyHeader>
                                <TableBodyHeader >{{ attendance.full_name }}</TableBodyHeader>
                                <TableBodyHeader >{{ attendance.student_school_name }}</TableBodyHeader>
                                <TableBody>{{ attendance_types[attendance.status] }}</TableBody>
                                <TableBody>{{ attendance.sign_in_time }}</TableBody>
                                <TableBody>{{ attendance.sign_off_time ?? ('Haven\'t Time Out Yet') }}</TableBody>
                                <TableBody>{{ attendance.notes }}</TableBody>
                                  
                            </TableRow>
                        </template>
                    </Table>
               

            
        </div>

        
    </AdminLayout>
</template>


