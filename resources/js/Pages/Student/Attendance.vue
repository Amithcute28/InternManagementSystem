<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import { useForm } from "@inertiajs/vue3";
import DataTable from "@/Components/DataTable.vue";
import FlexButton from "@/Components/FlexButton.vue";
import AttendanceTabs from "@/Components/Tabs/AttendanceTabs.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import {inject, ref, watch} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Card from "@/Components/Card.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";

import {computed, onMounted} from "vue";
import {initTooltips} from "flowbite";
import ToolTip from "@/Components/ToolTip.vue";
import Swal from "sweetalert2";




const props = defineProps({
    attendanceList: Object,
    dateParam: String,
    EmployeeStats: Object,
    files: Array,
});


const date = ref(new Date(props.dateParam));
if (props.dateParam === '') {
    date.value = '';
}
const search = (() => {
    if (date.value === null) {
        router.visit(route('attendance.index', {term: null}), {preserveState: true, preserveScroll: true})

    } else {
        router.visit(route('attendance.index', {term: date.value.toISOString().split('T')[0]}), {
            preserveState: true,
            preserveScroll: true
        })
    }
});
watch(date, search);


onMounted(() => {
    initTooltips();
});


const workableThisYear = computed(() => {
  // Use your fixed values for total working days in a year
  const totalWorkingDaysThisYear = 24;
  return totalWorkingDaysThisYear;
});

const attendancePercentage = computed(() => {
  // Use your fixed values for total working days in a year
  const totalWorkingDaysThisYear = 24;
  return (props.EmployeeStats['totalAttendanceSoFar'] / totalWorkingDaysThisYear * 100).toFixed(0);
});

const absencePercentage = computed(() => {
  // Use your fixed values for total working days in a year
  const totalWorkingDaysThisYear = 24;
  return ((props.EmployeeStats['totalAbsenceSoFar'] / totalWorkingDaysThisYear) * 100).toFixed(0);
});


const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const forms = useForm({
  studentId: props.attendanceList?.id,
  studentName: props.attendanceList?.full_name,
  program: props.attendanceList?.program,
  journal: null,
});

const submit = () => {
  const form = {
     studentId: forms.studentId,
    studentName: forms.studentName,
    program: forms.program,
    journal: forms.journal,
  };

  Swal.fire({
    title: "Submit Journal",
    text: "Are you sure you want to submit the Journal for today?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, submit it!",
  }).then((result) => {
    if (result.isConfirmed) {
      router
        .post(route("update.attendance", forms.id), {
          _method: "put",
          ...form,
        })
        .then(() => {
          Swal.fire(
            "Submitted!",
            "Evaluation form has been submitted.",
            "success"
          );
        })
        .catch(() => {
          Swal.fire("Error!", "Failed to submit evaluation form.", "error");
        });
    }
  });
};

const deleteAction = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to delete. This action cannot be undone. Are you sure you want to delete?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      forms.delete(route("deleteJournal.index", id));
    }
  });
};

const journal = ref(null);

function openModalEvalForm(intern) {
  forms.id = intern.id;
   (forms.full_name = intern.full_name),
    (forms.program = intern.program),
    (journal.value = forms),
  document.getElementById("myModalEvalForm").showModal();
}


</script>

<template>
<div>
    <Head :title="('Attendance')"/>
    <UserLayout>
        <template #tabs>
            <AttendanceTabs/>
        </template>
        <div class="py-8 mt-10">
          <p class="text-2xl font-semibold ml-4">Attendance List</p>
            
              

         <div>
        <Card>
        <h1 class="text-2xl mb-6">{{('Total Attendance')}}</h1>
    <div class="mt-4">
    <h2 class="font-bold mb-1">{{ 'Attendance' }}</h2>
    <p class="mb-2">
      {{ `Attended ${EmployeeStats.totalAttendanceSoFar} from ${workableThisYear}` }}
    </p>
    <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
      <div
        class="bg-green-500 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
        :style="{ width: `${attendancePercentage > 100 ? 100 : attendancePercentage}%` }"
      >
        {{ `${attendancePercentage}%` }}
      </div>
    </div>
  </div>

                    <div class="mt-4">
                        <h2 class="font-bold mb-1 mt-4">{{('Absence')}}</h2>
                       <p class="mb-2">
  {{ `Absented: ${EmployeeStats['totalAbsenceSoFar'] || 0} of ${EmployeeStats['YearStats'] ? EmployeeStats['YearStats']['absence_limit'] || 0 : 0}` }}
</p>
                        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div
                                class="bg-red-500 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                :style="'width:'+ (absencePercentage > 100 ? 100 : absencePercentage) + '%'"> {{ absencePercentage+'%' }}
                            </div>
                        </div>
                    </div>


                    
                </Card>
                        </div>

                       <div>
                  <Card>
                  
                   <div class="mt-4">
    <h2 class="inline font-bold mt-8">{{ 'Total Hours' }}</h2>

    <p class="mb-2 mt-1">
      {{ `Attended ${EmployeeStats.actualHoursThisMonth.toFixed(2)} of ${EmployeeStats.expectedHoursThisMonth} Hours` }}
    </p>

    <p class="mb-2 mt-1">
      {{ `Progress So Far: ${EmployeeStats.hoursDifferenceSoFar.toFixed(2)} Hours` }}
    </p>

    <p class="mb-2 mt-1">
      Remaining Until Month's End: <span v-if="EmployeeStats.hoursDifference > 0">+</span>
      {{ EmployeeStats.hoursDifference.toFixed(2) }} Hours.
    </p>
  </div>
                </Card>
                       </div>
                       
                    
  
      <div class="flex justify-between items-center pb-4 gap-4">
          <div></div>
          <div>
              <InputLabel for="date" :value="('Filter by Date:')"/>
              <VueDatePicker
                  id="date"
                  v-model="date"
                  class="py-1 block w-full"
                  :placeholder="('Select a Date..')"
                  :enable-time-picker="false"
                  :max-date="new Date()"
                  :dark="inject('isDark')"
                  required
              ></VueDatePicker>
              <InputError v-if="Object.keys($page.props.errors).length" class="mt-2"
                          :message="$page.props.errors"/>
          </div>
      </div>

                    <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell>Date</TableHeaderCell>
            <TableHeaderCell>Status</TableHeaderCell>
            <TableHeaderCell>Sign In Time</TableHeaderCell>
            <TableHeaderCell>Sign Off Time</TableHeaderCell>
            <TableHeaderCell>Notes</TableHeaderCell>
            <TableHeaderCell>Journal</TableHeaderCell>
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="form in attendanceList" :key="form.id">
             <TableDataCell>{{ form.date }}</TableDataCell>
                   <TableDataCell>{{ form.status }}</TableDataCell>        
            <TableDataCell>{{ form.sign_in_time }}</TableDataCell>
            <TableDataCell>{{ form.sign_off_time }}</TableDataCell>
             <TableDataCell>{{ form.notes }}</TableDataCell>
              <TableDataCell
              ><a
                v-if="isImage(form.journal)"
                :href="form.journal"
                target="_blank"
              >
                <img
                  :src="form.journal"
                  style="max-width: 100%; max-height: 100px"
                  class="h-16 w-16"
                />
              </a>
              <a
                v-else-if="isPdf(form.journal)"
                :href="form.journal"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.journal)"
                :href="form.journal"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.journal"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
             <TableDataCell
              ><div class="flex item-center space-x-2">

                <svg
                  @click="openModalEvalForm(form)"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-5 h-5 transform hover:text-purple-500 hover:scale-110"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
                
                
                <svg
                      @click="deleteAction(form.id)"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-5 h-5 transform hover:text-purple-500 hover:scale-110"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>

                </div>

                

                <Link
                  :href="route('newstudents.destroy', form.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >


            </TableDataCell> 


          </TableRow>
        </template>
      </Table>
                
            

           
        </div>
    </UserLayout>
    </div>

<dialog id="myModalEvalForm" class="p-5 bg-darkWhite rounded-md">
      <div class="flex w-full h-auto justify-between items-center">
        <div
          class="flex h-auto py-3 justify-center items-center text-2xl font-bold"
        >
          Journal
        </div>
        <div
          onclick="document.getElementById('myModalEvalForm').close();"
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

        <form
          class="py-6 px-9"
          @submit.prevent="submit"
          action="https://formbold.com/s/FORM_ID"
          method="POST"
        >
          <div class="mb-6 pt-4">
            <label class="mb-5 block text-xl font-semibold text-[#07074D]">
              Upload you Journal Today
            </label>

            <div class="mb-8">
              <input
                type="file"
                accept=".pdf"
                @input="forms.journal = $event.target.files[0]"
                name="journal"
                id="journal"
                class="sr-only"
              />
              <label
                for="journal"
                class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center"
              >
                <div>
                  <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                    Drop files here
                  </span>
                  <span class="mb-2 block text-base font-medium text-[#6B7280]">
                    Or
                  </span>
                  <span
                    class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]"
                  >
                    Browse
                  </span>
                </div>
              </label>
            </div>

            <div
              class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8"
              v-if="forms.journal"
            >
              <div class="flex items-center justify-between">
                <span
                  class="truncate pr-3 text-base font-medium text-[#07074D]"
                >
                  {{ forms.journal.name }}
                </span>
                <button class="text-[#07074D]">
                  <svg
                    width="10"
                    height="10"
                    viewBox="0 0 10 10"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                      fill="currentColor"
                    />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                      fill="currentColor"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <div>
            <button
              type="submit"
              onclick="document.getElementById('myModalEvalForm').close();"
              class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </dialog>

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