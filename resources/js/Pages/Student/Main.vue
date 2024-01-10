<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';
import {computed, onMounted, ref, watch} from 'vue';
import {daysUntilNthDayOfMonth} from "@/Composables/daysUntilNthDayOfMonthCalculator.js";
import {daysBetweenNthDates} from "@/Composables/daysBetweenNthDatesCalculator.js";
import NavLink from "@/Components/NavLink.vue";
import GoBackNavLink from "@/Components/GoBackNavLink.vue";
import Card from "@/Components/Card.vue";
import BlockQuote from "@/Components/BlockQuote.vue";
import IconCard from "@/Components/IconCard.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import ToolTip from "@/Components/ToolTip.vue";
import PrimaryButton2 from "@/Components/PrimaryButton2.vue";
import Swal from "sweetalert2";
import HorizontalRule from "@/Components/HorizontalRule.vue";
import MoneyIcon from "@/Components/Icons/MoneyIcon.vue";
import CalendarIcon from "@/Components/Icons/CalendarIcon.vue";
import TableIcon from "@/Components/Icons/TableIcon.vue";
import MessageIcon from "@/Components/Icons/MessageIcon.vue";
import {__} from "@/Composables/useTranslations.js";
import {CallQuoteAPI} from "@/Composables/useCallQuoteAPI.js";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    salary: Object,
    payroll_day: Number,
    employee_stats: Object,
    attendance_status: Number,
    is_today_off: Boolean,
    users: Object,
});
const days_remaining = computed(() => {
    return daysUntilNthDayOfMonth(props.payroll_day);
});




const today = (new Date()).toLocaleDateString(usePage().props.locale,
    { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric' });

const form = useForm({});

const msg = computed(() => {
    return (props.attendance_status === 0) ? ('Sign in') : ('Sign off')
})

let isSignIn = props.attendance_status === 0;
watch(() => props.attendance_status,
    () => {
        isSignIn = (props.attendance_status === 0);
    }
)
const submit = async () => {
  const postRoute = isSignIn ? 'attendance.dashboardSignIn' : 'attendance.dashboardSignOff';

  const confirmed = window.confirm(`Confirm ${isSignIn ? 'Sign in' : 'Sign off'} for attendance for ${today}?`);

  if (confirmed) {
    try {
      await form.post(route(postRoute, { id: usePage().props.auth.user.id }));
      alert(`Action Registered${isSignIn ? "\nDon't forget to come here and sign-off before you leave so that the attendance gets registered!" : ''}`);
    } catch (error) {
      alert('Error: Something went wrong. Please try again later.');
    }
  }
};


const quote = ref(null);
onMounted(() => {
    CallQuoteAPI(quote);
});

</script>

<template>
<div>
    <Head :title="('Dashboard')"/>
    <UserLayout>
        <template #tabs>
            <!-- <GoBackNavLink/>
            <NavLink :href="route('dashboard.index')" :active="route().current('dashboard.index')">
                {{ ('Dashboard') }}
            </NavLink> -->
        </template>

        <div class="py-8 mt-10">
            
                 <div class="flex justify-between gap-4 ">
                    <Card class="w-full md:w-3/4 !mt-0">
                        <h1 class="!card-header !mb-0 mt-6 ml-6">Welcome,
                            {{ $page.props.auth.user.full_name }}!</h1>
                    </Card>
                    <Card class="w-full md:w-1/4 !mt-0" vl :fancy-p="false">
                        <form @submit.prevent="submit" class="w-full h-full"
                              v-if="attendance_status !== 2 && !is_today_off">
                            <PrimaryButton2 class="w-full h-full flex justify-center">
                            <span class="text-xl">Attendance{{ msg }}
                                <br>
                                <span class="text-xs text-gray-200">{{ ('For') }}  {{ today }}</span>
                            </span>
                            </PrimaryButton2>
                        </form>
                        <PrimaryButton2 v-else
                                       class="w-full h-full flex justify-center !border-0 bg-gradient-to-r from-green-500 to-green-400 cursor-not-allowed"
                                       disabled>
                            <span v-if="is_today_off" class="text-xl py-6 ">{{ ('Today is off! 🕺🕺') }}<br></span>
                            <span v-else class="text-xl px-10">{{ ('Attendance Taken Today! 🎉') }}<br></span>
                        </PrimaryButton2>
                    </Card>
                </div>

                <!-- QUOTE + SALARY -->
                <div class="flex flex-col md:flex-row justify-between md:gap-4">
                    <Card class="w-full md:w-3/4">
                        <h1 class="text-2xl">{{ ('Quote of the day') }}</h1>
                        <div class="flex justify items-center">
                            <BlockQuote class="mb-0 ml-6" v-if="quote" :style="2" :quote="quote['content']"
                                        :author="quote['author']"/>
                            <BlockQuote class="mb-0 ml-6" v-else :style="2" :quote="('Loading Quote...')"
                                        :author="('Loading Author...')"/>
                        </div>
                    </Card>

                   
                </div>

               
              

                <!-- QUICK ACTIONS -->
                  <Link
                v-for="user in users"
                :key="user.id"
                :href="route('user.edit', user.id)"
                class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-gold hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
                >Edit Information</Link
              >
            

           
        </div>
        
    </UserLayout>
    </div>
</template>


<style scoped>
@keyframes glowing {
    0% {
        box-shadow: 0 0 5px indigo;
    }
    50% {
        box-shadow: 0 0 10px indigo, 0 0 15px indigo;
    }
    100% {
        box-shadow: 0 0 5px indigo;
    }
}

.glow-element {
    animation: glowing 7s infinite;
}

</style>
