<script setup>
import AdminLayoutBSED from '@/Layouts/AdminLayoutBSED.vue';
import {Head, Link, router} from '@inertiajs/vue3';
import FlexButton from "@/Components/FlexButton.vue";
import CalendarTabs from "@/Components/Tabs/CalendarTabs.vue";
import Card from "@/Components/Card.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import {calendar_types} from "@/Composables/useCalendarItemTypes.js";
import Table from "@/Components/Table/Table.vue";
import TableBodyHeader from "@/Components/Table/TableBodyHeader.vue";
import TableBody from "@/Components/Table/TableBody.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import TableRow from "@/Components/Table/TableRow.vue";
import TableBodyAction from "@/Components/Table/TableBodyAction.vue";


defineProps({
    calendarItems: Object,
})
</script>
<template>
    <Head :title="('Calendar Items')"/>
    <AdminLayoutBSED>
        <template #tabs>
            <CalendarTabs />
        </template>
        <div class="py-8 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center pb-4">
                    <p class="text-2xl font-semibold ml-4 mb-6">Calendar Items</p>
                        <FlexButton :href="route('calendar-bsed.createBsed')" :text="('Create a New Item')">
                            <PlusIcon/>
                        </FlexButton>
                    </div>
                <Card class="!mt-0">
                    
                    <Table :links="calendarItems.links" :showingNumber="calendarItems.data.length"
                           :totalNumber="calendarItems.total">
                        <template #Head>
                            <TableHead>{{('ID')}}</TableHead>
                            <TableHead>{{('Title')}}</TableHead>
                            <TableHead>{{('Type')}}</TableHead>
                            <TableHead>{{('Start Date')}}</TableHead>
                            <TableHead>{{('End Date')}}</TableHead>
                            <TableHead>{{('Actions')}}</TableHead>
                        </template>

                        <!--Iterate Here-->
                        <template #Body>
                            <TableRow v-for="item in calendarItems.data" :key="item.id">
                                <TableBodyHeader>
                                    <Link :href="route('calendar.show', {id: item.id})">{{ item.id }}</Link>
                                </TableBodyHeader>
                                <TableBodyHeader>
                                    <Link :href="route('calendar.show', {id: item.id})">{{ item.title }}</Link>
                                </TableBodyHeader>
                                <TableBody>
                                    <Link :href="route('calendar.show', {id: item.id})">{{ calendar_types[item.type] }}</Link>
                                </TableBody>
                                <TableBody>
                                    <Link :href="route('calendar.show', {id: item.id})">{{ item.start_date }}</Link>
                                </TableBody>
                                <TableBody>
                                    <Link :href="route('calendar.show', {id: item.id})">{{ item.end_date ?? ('None') }}</Link>
                                </TableBody>
                                <TableBodyAction>
                                    <Link :href="route('calendar.editBsed', {id: item.id})"> {{('Edit')}}</Link>
                                </TableBodyAction>
                            </TableRow>
                        </template>
                    </Table>

                </Card>

            </div>
        </div>
    </AdminLayoutBSED>
</template>
