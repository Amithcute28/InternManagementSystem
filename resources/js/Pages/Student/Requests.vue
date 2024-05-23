<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head} from '@inertiajs/vue3';
import FlexButton from "@/Components/FlexButton.vue";
import ReqTabs from "@/Components/Tabs/ReqTabs.vue";
import Card from "@/Components/Card.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue";
import TableBody from "@/Components/Table/TableBody.vue";
// import TableRow from "@/Components/Table/TableRow.vue";
import TableBodyHeader from "@/Components/Table/TableBodyHeader.vue";
// import Table from "@/Components/Table/Table.vue";
import TableHead from "@/Components/Table/TableHead.vue";
import {__} from "@/Composables/useTranslations.js";
import {request_types} from "@/Composables/useRequestTypes.js";
import {request_status_types} from "@/Composables/useRequestStatusTypes.js";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";

defineProps({
    requests: Object,
})

</script>
<template>
    <Head :title="('Requests')"/>
    <UserLayout>
        <template #tabs>
            <ReqTabs />
        </template>
        <div class="py-8 mt-10">
            <p class="text-2xl font-semibold ml-4 mb-6">Current Requests</p>
            
                    <div class="flex justify-between items-center pb-4">

                        <FlexButton :href="route('requests.create')"
                                    :text="('Initiate A Request')">
                            <PlusIcon/>
                        </FlexButton>
                    </div>
                   
                      <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell>ID</TableHeaderCell>
            <TableHeaderCell>Created By</TableHeaderCell>
            <TableHeaderCell>Type</TableHeaderCell>
            <TableHeaderCell>Start Date</TableHeaderCell>
            <TableHeaderCell>End Date</TableHeaderCell>
            <TableHeaderCell>Status</TableHeaderCell>
          </TableRow>
        </template>
         <template #default>
                            <TableRow v-for="request in requests" :key="request.id">
                                <TableBodyHeader :href="route('requests-show-student.show', {id: request.id})">{{request.id}}</TableBodyHeader>
                                <TableBodyHeader :href="route('requests-show-student.show', {id: request.id})" >{{request.full_name}}</TableBodyHeader>
                                <TableBody :href="route('requests-show-student.show', {id: request.id})">{{request_types[request.type]}}</TableBody>
                                <TableBody :href="route('requests-show-student.show', {id: request.id})">{{request.start_date}}</TableBody>
                                <TableBody :href="route('requests-show-student.show', {id: request.id})">{{request.end_date ?? ('N/A')}}</TableBody>
                                <TableBody :href="route('requests-show-student.show', {id: request.id})">
                                    {{  request.status === "Pending" ? request_status_types['pending'] + ' ⏳' :
                                        request.status === "Approved" ? request_status_types['approved'] + ' ✅' :
                                            request_status_types['rejected'] + ' 🚫'
                                    }}
                                    <span class="text-red-500 text-xs font-bold"
                                        v-if="!$page.props.auth.user.roles && request.status !== 'Pending' && !request.is_seen">
                                        <sup>**</sup>
                                    </span>
                                </TableBody>
                            </TableRow>
                        </template>
        <!-- Additional content for the table -->
      </Table>
            
        </div>
    </UserLayout>
</template>
