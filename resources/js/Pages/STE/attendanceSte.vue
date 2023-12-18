<script setup>
import SteLayout from '@/Layouts/SteLayout.vue';
import {Head, router} from '@inertiajs/vue3';
import DataTableSte from "@/Components/DataTableSte.vue";
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
        router.visit(route('ste-attendance.attendanceSte', {term: null}), {preserveState: true, preserveScroll: true})

    } else {
        router.visit(route('ste-attendance.attendanceSte', {term: date.value.toISOString().split('T')[0]}), {
            preserveState: true,
            preserveScroll: true
        })
    }
});
watch(date, search);

</script>

<template>
    <Head :title="('Attendance')"/>
    <SteLayout>
        <template #tabs>
            <AttendanceTabs/>
        </template>
        <div class="py-8 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <h1 class="card-header !mb-4">{{ ('Attendance List') }}</h1>
                    <div class="flex justify-between items-center pb-4 gap-4">
                        <FlexButton :href="route('ste-dashboard.create')" :text="('Take/Edit Attendance')">
                            <PlusIcon/>
                        </FlexButton>
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
                    <DataTableSte
                        :controller="'ste-attendances'"
                        :head='[("Date"), ("Total Attendance"), ("Attended On Time"), ("Attended Late"), ("Absented")]'
                        :data="attendanceList"
                        :hasActions="false"
                        :hasLink="true"
                        :hasCustomParams="true"
                        :customParamsHeader="'date'"
                        :customParamsIndex="0"
                    ></DataTableSte>
                </Card>
            </div>
        </div>
    </SteLayout>
</template>
