<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';

defineProps(["roles"]);
</script>

<template>
    <Head title="Roles" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto py-4">
           <div class="flex justify-between">
            <h1>Roles</h1>
            <Link :href="route('role.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">New Role</Link>
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
                        <TableHeaderCell>ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                    </template>

                    <template #default>
                        
                        <TableRow class="overflow-auto" v-for="role in roles" :key="role.id">
                            <td class="w-4 p-4">
                            <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                            </td>
                            <TableDataCell>{{ role.id }}</TableDataCell>
                             <TableDataCell>{{ role.name}}</TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('role.edit', role.id)" class="text-green-400 hover:text-green-600">Edit</Link>
                                <Link :href="route('role.destroy', role.id)" method="DELETE" as="button" class="text-red-400 hover:text-red-600">Delete</Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
               
            </div>
        </div>
    </AdminLayout>

  
</template>
