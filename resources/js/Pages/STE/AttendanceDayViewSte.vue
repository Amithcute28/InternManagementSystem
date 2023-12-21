<script setup>
import SteLayout from '@/Layouts/SteLayout.vue';
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

const props = defineProps({
    attendanceList: Object,
    day: String,

});

const destroy = () => {
    if (window.confirm('Are you sure? You won\'t be able to revert this!')) {
        useForm({}).delete(route('ste.destroy', { date: props.day }), {
            preserveScroll: true,
            onError: () => {
                alert('Error Deleting Attendance');
            },
            onSuccess: () => {
                alert('Attendance Removed!', '', 'success');
            },
        });
    }
};


</script>

<template>
    <Head :title="('Attendance View')"/>
    <SteLayout>
        <template #tabs>
            <AttendanceTabs />
        </template>
        <div class="py-8 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <h1 class="card-header !mb-6">{{('Attendance List for :day', {day: day})}}</h1>
                    <div class="flex justify-between items-center pb-4 gap-4">
                        <div class="flex justify-center items-center inline">
                            <FlexButton :href="route('ste-dashboard.create')" :text="('Retake/Update Attendance')">
                                <TrashIcon/>
                            </FlexButton>
                        </div>
                        <form @submit.prevent="destroy" class="flex justify-center items-center ">
                            <PrimaryButton class="bg-red-600 hover:bg-red-700 focus:bg-red-500 active:bg-red-900" >
                                <TrashIcon/>
                                {{('Delete Day Attendance')}}
                            </PrimaryButton>
                        </form>
                    </div>

                    <Table :links="attendanceList.links" :showingNumber="attendanceList.data.length"
                           :totalNumber="attendanceList.total">
                        <template #Head>
                            <TableHead>{{('ID')}}</TableHead>
                            <TableHead>{{('Student')}}</TableHead>
                            <TableHead>{{('Status')}}</TableHead>
                            <TableHead>{{('Sign In Time')}}</TableHead>
                            <TableHead>{{('Sign Off Time')}}</TableHead>
                            <TableHead>{{('Notes')}}</TableHead>
                        </template>

                        <!--Iterate Here-->
                        <template #Body>
                            <TableRow v-for="attendance in attendanceList.data" :key="attendance.id">
                                <TableBodyHeader>{{ attendance.student_id }}</TableBodyHeader>
                                <TableBodyHeader >{{ attendance.full_name }}</TableBodyHeader>
                                <TableBody>{{ attendance_types[attendance.status] }}</TableBody>
                                <TableBody>{{ attendance.sign_in_time }}</TableBody>
                                <TableBody>{{ attendance.sign_off_time ?? ('Haven\'t Sign Off Yet') }}</TableBody>
                                <TableBody>{{ attendance.notes }}</TableBody>
                            </TableRow>
                        </template>
                    </Table>
                </Card>

            </div>
        </div>
    </SteLayout>
</template>
