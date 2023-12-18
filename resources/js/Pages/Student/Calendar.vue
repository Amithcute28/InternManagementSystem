<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import CalendarTabs from "@/Components/Tabs/CalendarTabs.vue";
import {CalendarView, CalendarViewHeader} from "vue-simple-calendar";
import "@/../../node_modules/vue-simple-calendar/dist/style.css";
import "@/../../node_modules/vue-simple-calendar/dist/css/default.css"
import "@/../../node_modules/vue-simple-calendar/dist/css/holidays-us.css"
import {computed, inject, onMounted, ref} from "vue";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import FlexButton from "@/Components/FlexButton.vue";
import Card from "@/Components/Card.vue";
import TextInput from "@/Components/TextInput.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import {__} from "@/Composables/useTranslations.js";
import {calendar_types} from "@/Composables/useCalendarItemTypes.js";
import dayjs from "dayjs";


const form = useForm({
    date: '',
    title: '',
    type: 'meeting',
});

const submitForm = () => {
    Object.keys(form.date).forEach(function (key) {
        if (form.date[key] && !/^\d{4}-\d{2}-\d{2}$/.test(form.date[key])){
            form.date[key] = dayjs(form.date[key]).format('YYYY-MM-DD');
        }
    });
    form.post(route('calendar.store'), {
        preserveScroll: true,
        onError: () => {
            useToast().error(('Error Creating Calendar Item'));
        },
        onSuccess: () => {
            useToast().success(('Calendar Item Stored Successfully'));
            form.reset();
        }
    });
};

const props = defineProps({
    calendarItems: Array, // Assuming that calendarItems should be an array
    leaveRequests: Array, // Assuming that leaveRequests should be an array
});

const items = computed(() => {
    // Check if props.calendarItems is an array
    const obj1 = Array.isArray(props.calendarItems) ? props.calendarItems.map(item => {
        const { start_date, end_date, id, title, type } = item;
        return {
            id: id,
            title: "[" + calendar_types[type].toUpperCase() + "] " + title,
            startDate: start_date,
            endDate: end_date
        };
    }) : [];

    // Check if props.leaveRequests is an array
    const obj2 = Array.isArray(props.leaveRequests) ? props.leaveRequests.map(item => {
        const { start_date, end_date, id } = item;
        return {
            id: id,
            title: __('[ :type ] :name', { type: ('Approved Leave'), name: item.employee.name }),
            startDate: start_date,
            endDate: end_date
        };
    }) : [];

    return obj1.concat(obj2);
});

const themeClasses = computed(() => {
    return {
        "theme-default": true,
        "holiday-us-traditional": false,
        "holiday-us-official": false,
    }
});

const showDate = ref(new Date());
function setShowDate(d) {
    showDate.value = d;
}

onMounted(() => {
    // Set the Initial Date to Today.
    // You can use any date you want like this new Date('2011-01-25').
    setShowDate(new Date());

    // To change the color of leave requests
    const element = document.querySelectorAll('.cv-item');
    for (let i = 0; i < element.length; i++) {
        const content = element[i].textContent;
        if (content.includes("[Approved Leave]")) {
            element[i].style.setProperty('background-color', '#ffc5c5', 'important');
        }
        else if (content.includes("["+calendar_types['holiday'].toUpperCase()+"]")) {
            element[i].style.setProperty('background-color', '#c7f6ca', 'important');
            element[i].style.setProperty('font-weight', 'bold', 'important');
        }
        else if (content.includes("["+calendar_types['meeting'].toUpperCase()+"]")) {
            element[i].style.setProperty('background-color', '#c5d4ff', 'important');
        }
        else if (content.includes("["+calendar_types['event'].toUpperCase()+"]")) {
            element[i].style.setProperty('background-color', '#bce6ef', 'important');
        }
        else if (content.includes("["+calendar_types['other'].toUpperCase()+"]")) {
            element[i].style.setProperty('background-color', '#ffe1c5', 'important');
        }
    }
});
</script>

<template>
<div>
    <Head :title="('Calendar')"/>
    <UserLayout>
        <template #tabs>
            <CalendarTabs />
        </template>
        <div class="py-8 mt-10">
            <p class="text-2xl font-semibold ml-4">Calendar</p>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card :fancy-p="false" class="mt-6">
                    <div class="flex justify-between px-6 pt-6 pb-2">
                        <!-- <h1 class="card-header">{{('Current Calendar')}}</h1> -->
                        

                        
                   
                    </div>
                    <div class="fancy-p py-0">
                        <calendar-view
                            dir="ltr"
                            class="!dark:text-black"
                            :items="items"
                            :show-date="showDate"
                            :startingDayOfWeek="6"
                            :class="themeClasses"
                            style="min-height: 30em;"
                        >
                            <template #header="{ headerProps }">
                                <calendar-view-header
                                    :header-props="headerProps"
                                    @input="setShowDate" />
                            </template>
                        </calendar-view>
                    </div>
                </Card>

            </div>
        </div>
    </UserLayout>
    </div>
</template>

<style>

.theme-default .cv-day.today {
    background-color: #d9c161;
}
.currentPeriod:after {
    content: ' (Click to return to current month)';
}
.theme-default .cv-day.past {
    background-color: #0ac06d1f;
}
.theme-default .cv-header button{
    background-color: white;
}
.theme-default .cv-day.past:after {
    content: '✅️';
    padding-top: 0.25em;
    opacity: 60%;
}

.theme-default .cv-day.outsideOfMonth {
    background-color: #878787;
}

.theme-default .cv-header, .theme-default .cv-header-day{
    background-color: #afafaf;
}
.theme-default .cv-item.continued::before, .theme-default .cv-item.toBeContinued::after{

}
.cv-item {
    color: black;
}


</style>

