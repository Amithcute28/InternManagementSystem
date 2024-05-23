<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
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

const props = defineProps({
    attendanceList: Object,
    dateParam: String,
});

const date = ref(new Date(props.dateParam));
if (props.dateParam === '') {
    date.value = '';
}
const search = (() => {
    if (date.value === null) {
        router.visit(route('attendance-list.attendanceList', {term: null}), {preserveState: true, preserveScroll: true})

    } else {
        router.visit(route('attendance-list.attendanceList', {term: date.value.toISOString().split('T')[0]}), {
            preserveState: true,
            preserveScroll: true
        })
    }
});
watch(date, search);

</script>

<template>
    <Head :title="('Attendance')"/>
    <AdminLayout>
        <template #tabs>
            <AttendanceTabs/>
        </template>
        <div class="py-8 mt-10">
            <p class="text-2xl font-semibold ml-4 mb-6">Attendance List</p>
                
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
                    <DataTable
                        :controller="'attendances'"
                        :head='[("Date"), ("Total Attendance"), ("On Time"), ("Late"), ("Absents")]'
                        :data="attendanceList"
                        :hasActions="false"
                        :hasLink="true"
                        :hasCustomParams="true"
                        :customParamsHeader="'date'"
                        :customParamsIndex="0"
                    ></DataTable>
               
           
        </div>
    </AdminLayout>
</template>
