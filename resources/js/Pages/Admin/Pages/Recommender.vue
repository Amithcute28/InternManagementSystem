<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Recommendations from '@/Components/Recommendations.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Table from '@/Components/Table.vue';
import TableRow from '@/Components/TableRow.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import axios from 'axios';
import { ref } from 'vue';



const opportunities = ref([]);

axios.get('/api/practice-teaching-opportunities').then((response) => {
  opportunities.value = response.data;
});

defineProps(["recommenders"]);
</script>

<template>
    <Head title="Recommender" />

    <AdminLayout>
        <div class="mt-16">
            <div class="flex justify-between">
            <h1></h1>
             <!-- <div>
    <h1>Practice Teaching Opportunities</h1>
    <ul>
      <li v-for="opportunity in opportunities" :key="opportunity.id">
        {{ opportunity.title }}
      </li>
    </ul>
  </div> -->
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
                        <TableHeaderCell>Course</TableHeaderCell>
                        <TableHeaderCell>Status</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                    </template>

                    <template #default>
                        
                       <TableRow class="overflow-auto" v-for="recommender in recommenders" :key="recommender.id">
                            <td class="w-4 p-4 bg-white">
                            <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                            </td>

                            <TableDataCell>{{ recommender.id }}</TableDataCell>
                            <TableDataCell class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="@/Assets/profile.jpg" alt="Jese image">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ recommender.full_name}}</div>
                                    <div class="font-normal text-gray-500">{{ recommender.email}}</div>
                                     </div>  
                            </TableDataCell>
                             <TableDataCell>BSIT</TableDataCell>
                            <TableDataCell>
                             <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Pending
                             </div>
                            </TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('recommender.edit', recommender.id)"  class="text-green-400 hover:text-green-600">Recommend</Link>
                                <Link :href="route('recommender.destroy', recommender.id)" method="DELETE" as="button" class="text-red-400 hover:text-red-600">Delete</Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
        </div>
        </div>
    </AdminLayout>
</template>
