<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import {computed, onMounted} from "vue";
import {initTooltips} from "flowbite";
import AttendanceTabs from "@/Components/Tabs/AttendanceTabs.vue";
import ToolTip from "@/Components/ToolTip.vue";
import Card from "@/Components/Card.vue";

onMounted(() => {
    initTooltips();
});

const props = defineProps({
    EmployeeStats: Object,
});

const workableThisYear = computed(() => {
  const yearStats = props.EmployeeStats && props.EmployeeStats['YearStats'];

  if (yearStats) {
    const workingDaysThisYear = yearStats['workingDaysThisYear'] || 0;
    const weekendsOffThisYear = yearStats['WeekendOffDaysThisYear'] || 0;
    const holidaysThisYear = yearStats['HolidaysThisYear'] || 0;

    return workingDaysThisYear - weekendsOffThisYear - holidaysThisYear;
  }

  return 0; // Return a default value or handle the case when EmployeeStats['YearStats'] is undefined
});

const attendancePercentage = computed(() => {
    return (props.EmployeeStats['totalAttendanceSoFar'] / (workableThisYear.value) * 100).toFixed(0);
});

const absencePercentage = computed(() => {
  const totalAbsenceSoFar = props.EmployeeStats && props.EmployeeStats['totalAbsenceSoFar'];
  const yearStats = props.EmployeeStats && props.EmployeeStats['YearStats'];

  if (totalAbsenceSoFar && yearStats && yearStats['absence_limit']) {
    return ((totalAbsenceSoFar / yearStats['absence_limit']) * 100).toFixed(0);
  }

  return 0; // Return a default value or handle the case when properties are undefined
});
</script>
<template>
    <Head :title="('Attendance Dashboard') "/>
    <UserLayout>
        <template #tabs>
            <AttendanceTabs/>
        </template>
        <div class="py-8 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <h1 class="text-2xl">{{('Attendance Dashboard')}}</h1>
                </Card>

                <Card>
                    <h1 class="text-2xl mb-6">{{('Your Attendance This Month (:attendance)', {attendance: new Date().toLocaleString('default', { month: 'long' })})}}</h1>

                    <!-- Attendance -->
                    <div class="mt-4">
                        <h2 class="font-bold mb-1">{{('Attendance')}}</h2>
                        <p class="mb-2">{{('Attended')}} {{ EmployeeStats['attendedThisMonth'] }} {{('of')}} {{ EmployeeStats['attendableThisMonth'] }} {{('Days')}}.</p>
                    </div>

                    <hr class="my-3 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50"/>

                    <!-- Absence -->
                    <div class="mt-4">
                        <h2 class="font-bold mb-1 mt-4">{{('Absence')}}</h2>
                        <p class="mb-2">{{('Absented')}} {{ EmployeeStats['absentedThisMonth'] }} {{('Days')}}.</p>
                    </div>

                    <hr class="my-3 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50"/>

                    <!-- Hours -->
                    <div class="mt-4">
                        <h2 class="inline font-bold mt-8">{{('Hour Compensation')}}</h2>
                        <ToolTip>
                            <div>{{('Compensation Hours are the hours you have worked more/less than the required hours')}}.</div>
                            <div>{{('Extra Hours are rewarded, while negative hours will result in deduction..')}}</div>
                            <div>{{('The final numbers are cleared and accounted in the payroll by the end of the month.')}}</div>
                        </ToolTip>

                        <p class="mb-2 mt-1">{{('Worked :worked of :of Hours', {worked: EmployeeStats['actualHoursThisMonth'].toFixed(2), of: EmployeeStats['expectedHoursThisMonth']})}}</p>

                        <p class="mb-2 mt-1">{{('Progress So Far: :hoursDifference Hours', {hoursDifference: EmployeeStats['hoursDifferenceSoFar'].toFixed(2)})}}</p>

                        <p class="mb-2 mt-1">{{('Remaining Until Month\'s End')}}: <span v-if="EmployeeStats['hoursDifference'] > 0">+</span> {{ EmployeeStats['hoursDifference'].toFixed(2)}} {{('Hours')}}.</p>
                    </div>
                </Card>

                <Card>
                    <h1 class="text-2xl mb-6">{{('Your Attendance This Year')}}</h1>

                    <!-- Attendance -->
                    <div class="mt-4">
                        <h2 class="font-bold mb-1">{{('Attendance')}}</h2>
                        <p class="mb-2">{{('Attended :attended from :from', {attended: EmployeeStats['totalAttendanceSoFar'], from: workableThisYear})}}</p>
                        <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                            <div
                                class="bg-green-500 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                                :style="'width:'+(attendancePercentage > 100 ? 100 : attendancePercentage)+'%'"> {{ attendancePercentage+'%' }}
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

                    <hr class="my-6 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50"/>

                    <!-- Days Breakdown -->
                    <div class="mt-4">
                        <h2 class="font-bold mb-1 mt-4">{{('Your Year\'s Data')}}</h2>
                        <div class="block mt-4">
                            <span class="inline">{{('Weekend Off Days')}}: </span>
                          <p class="mb-2 inline">
  {{ EmployeeStats['YearStats'] && EmployeeStats['YearStats']['weekendOffDays']
    ? EmployeeStats['YearStats']['weekendOffDays'].map(day => day.charAt(0).toUpperCase() + day.slice(1)).join(', ')
    : '' }}
</p>
                        </div>
                        <div class="block mt-2">
                            <span class="inline">{{('Your Total Weekend Days Off This Year')}}: </span>
                           <p class="mb-2 inline">
  {{ EmployeeStats['YearStats'] && EmployeeStats['YearStats']['WeekendOffDaysThisYear']
    ? `${EmployeeStats['YearStats']['WeekendOffDaysThisYear']} Days`
    : '' }}
</p>
                        </div>
                        <div class="block mt-2">
                            <span class="inline">{{('Your Total National Holidays Days')}}: </span>
                          <p class="mb-2 inline">
  {{ EmployeeStats['YearStats'] && EmployeeStats['YearStats']['HolidaysThisYear']
    ? `${EmployeeStats['YearStats']['HolidaysThisYear']} Days`
    : '' }}
</p>

                        </div>
                        <div class="block mt-2">
                            <span class="inline">{{('Your Total Off Days This Year (Weekends + Holidays)')}}: </span>
                          <p class="mb-2 inline">
  {{ EmployeeStats && EmployeeStats['YearStats'] && EmployeeStats['YearStats']['WeekendOffDaysThisYear'] && EmployeeStats['YearStats']['HolidaysThisYear']
    ? `${EmployeeStats['YearStats']['WeekendOffDaysThisYear'] + EmployeeStats['YearStats']['HolidaysThisYear']} Days`
    : '' }}
</p>

                        </div>
                    </div>

                    <hr class="my-6 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50"/>

                    <!-- Support -->

                    <div class="mt-5">
                        <p class="font-bold mb-2">{{('Something\'s Wrong?')}}</p>
                        <p>{{('If there is anything wrong in the presented data above please')}}
                            <Link :href="route('requests.create')" class="underline text-purple-700" >{{('Submit a Complaint Here')}}</Link>.
                        </p>
                    </div>
                </Card>
            </div>
        </div>
    </UserLayout>
</template>
