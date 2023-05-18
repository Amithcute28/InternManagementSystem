<script setup>
 import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link} from "@inertiajs/vue3";
    import { defineProps } from 'vue';
    import Table from '@/Components/Table.vue';
    import TableRow from '@/Components/TableRow.vue';
    import TableHeaderCell from '@/Components/TableHeaderCell.vue';
    import TableDataCell from '@/Components/TableDataCell.vue';


    const props = defineProps({
        students: {
            type: Array,
            required: true,
        },
    });
</script>

<template>
    <Head title="Off Campus" />

    <AdminLayout>
        <!-- <div class="mt-16 flex">

            <div class="w-full">
                <h1 class="text-xl font-bold mb-4">Students</h1>
                <div class="bg-white shadow-md rounded my-6">
                    <table class="w-full table-auto"> 
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Program</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Academic Performance</th>
                                <th class="py-3 px-4 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="student in students" :key="student.id" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4">{{ student.full_name }}</td>
                                <td class="py-3 px-4">{{ student.program }}</td>
                                <td class="py-3 px-4">{{ student.email }}</td>
                                <td class="py-3 px-4">{{ student.academic_performance }}</td>
                                <td class="py-3 px-4">
                                    <Link :href="route('offcampus.show', { id: student.id })" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</Link>
                                    <ul v-if="student.recommended_institutions.length > 0">
                                        <li v-for="institution in student.recommended_institutions" :key="institution.id">
                                            {{ institution.name }} - {{ institution.required_academic_performance }}
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        <div class="mt-16">
            <div class="flex justify-between">
            <h1>List of students</h1>
           </div>
            <div class="mt-6">
            <Table>
                    <template #header>
                    <TableRow>
                    <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                    </th>
                        <TableHeaderCell>Student ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Program</TableHeaderCell>
                        <TableHeaderCell>Status</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                    </template>

                    <template #default>
                        
                       <TableRow class="overflow-auto" v-for="student in students" :key="student.id">
                            <td class="w-4 p-4 bg-white">
                            <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                            </td>

                            <TableDataCell>{{ student.student_id }}</TableDataCell>
                            <TableDataCell class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="@/Assets/profile.jpg" alt="Jese image">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ student.full_name }}</div>
                                    <div class="font-normal text-gray-500">{{ student.email }}</div>
                                     </div>  
                            </TableDataCell>
                             <TableDataCell>{{ student.program }}</TableDataCell>
                            <TableDataCell>
                             <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Deployed
                             </div>
                            </TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('offcampus.show', student.id)"  class="text-green-400 hover:text-green-600">View</Link>
                               
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
        </div>
        </div>

    </AdminLayout>
</template>

