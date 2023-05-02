<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';

defineProps(["newstudents"]);


</script>

<template>
    <Head title="New Students" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto mt-16">
            <div>
                <Table>
                    <template #header>
                    <TableRow>
                    <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                    </th>
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Program</TableHeaderCell>
                        <TableHeaderCell>Status</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                    </template>

                    <template #default>
                        
                        <TableRow class="overflow-auto" v-for="newstudent in newstudents" :key="newstudent.id">
                            <td class="w-4 p-4 bg-white">
                            <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                            </td>

                            <TableDataCell>{{ newstudent.student_id }}</TableDataCell>
                            <TableDataCell class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="@/Assets/profile.jpg" alt="Jese image">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ newstudent.full_name}}</div>
                                    <div class="font-normal text-gray-500">{{ newstudent.email}}</div>
                                     </div>  
                            </TableDataCell>
                             <TableDataCell>{{ newstudent.program }}</TableDataCell>
                            <TableDataCell>
                             <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Online
                             </div>
                            </TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('newstudents.edit', newstudent.id)"  class="text-green-400 hover:text-green-600">Check</Link>
                                <Link :href="route('newstudents.destroy', newstudent.id)" method="DELETE" as="button" class="text-red-400 hover:text-red-600">Delete</Link>
                                <Link :href="route('newstudents.update', newstudent.id)" method="patch" as="button" class="text-green-400 hover:text-green-600">Approve</Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
               
            </div>
        </div>
    </AdminLayout>

  
</template>