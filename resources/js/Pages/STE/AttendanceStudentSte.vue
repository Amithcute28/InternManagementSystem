<script setup>
import SteLayout from '@/Layouts/SteLayout.vue';
import {Head, router} from '@inertiajs/vue3';
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




const props = defineProps({
    attendanceList: Object,
    dateParam: String,
    EmployeeStats: Object,
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
  
  const totalWorkingDaysThisYear = 24;
  return totalWorkingDaysThisYear;
});

const attendancePercentage = computed(() => {
  
  const totalWorkingDaysThisYear = 24;
  return (props.EmployeeStats['totalAttendanceSoFar'] / totalWorkingDaysThisYear * 100).toFixed(0);
});

const absencePercentage = computed(() => {
 
  const totalWorkingDaysThisYear = 24;
  return ((props.EmployeeStats['totalAbsenceSoFar'] / totalWorkingDaysThisYear) * 100).toFixed(0);
});
</script>

<template>
<div>
    <Head :title="('Attendance')"/>
    <SteLayout>
        <template #tabs>
            <AttendanceTabs/>
        </template>
        <div class="py-8 mt-10">
          <p class="text-2xl font-semibold ml-4">Attendance List</p>
            
              

         <div>
        <Card>
        <h1 class="text-2xl mb-6">{{('Total Attendance')}}</h1>

                    <!-- Attendance -->
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

                    <!-- Absence -->
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

               
                  

                    <!-- <hr class="my-6 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50"/> -->

                    <!-- Support -->

                    
                </Card>
                        </div>

                       <div>
                  <Card>
                    <!-- Attendance -->

                    <!-- Hours -->
                   <div class="mt-4">
    <h2 class="inline font-bold mt-8">{{ 'Total Hours' }}</h2>
    <!-- <ToolTip>
        <div>{{('Compensation Hours are the hours you have worked more/less than the required hours')}}.</div>
        <div>{{('Extra Hours are rewarded, while negative hours will result in deduction..')}}</div>
        <div>{{('The final numbers are cleared and accounted in the payroll by the end of the month.')}}</div>
    </ToolTip> -->

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
                    <!-- <DataTable
                        :controller="'attendance'"
                        :head='[("Date"), ("Status"), ("Attended On Time"), ("Attended Late"), ("Absented")]'
                        :data="attendanceList"
                        :hasActions="false"
                        :hasLink="true"
                        :hasCustomParams="true"
                        :customParamsHeader="'date'"
                        :customParamsIndex="0"
                    ></DataTable> -->

                    <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell>Date</TableHeaderCell>
            <TableHeaderCell>Status</TableHeaderCell>
            <TableHeaderCell>In Time</TableHeaderCell>
            <TableHeaderCell>Off Time</TableHeaderCell>
            <TableHeaderCell>Journal</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="form in attendanceList" :key="form.id">
             <TableDataCell>{{ form.date }}</TableDataCell>
                   <TableDataCell>{{ form.status }}</TableDataCell>        
            <TableDataCell>{{ form.sign_in_time }}</TableDataCell>
            <TableDataCell>{{ form.sign_off_time }}</TableDataCell>
             <TableDataCell>{{ form.notes }}</TableDataCell>


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
        <!-- Additional content for the table -->
      </Table>
                
            

           
        </div>
    </SteLayout>
    </div>
</template>
