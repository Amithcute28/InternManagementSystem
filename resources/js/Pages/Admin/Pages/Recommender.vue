<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link, router } from "@inertiajs/vue3";
    import Table from '@/Components/Table.vue';
    import TableRow from '@/Components/TableRow.vue';
    import TableHeaderCell from '@/Components/TableHeaderCell.vue';
    import TableDataCell from '@/Components/TableDataCell.vue';

    import { defineProps } from 'vue';

    const props = defineProps({
        students: {
            type: Array,
            required: true,
        },
        institutions: {
        type: Array,
        required: true
    },
    });

const updateRecommendation = institutionId => {
  window.location.href = `/recommender/updateInstitution/${userId}/${institutionId}`;
};

const recommendUpdated = (student) => {
  console.log(student.id);
  router.put(route("recommender.updateRecommender", { id: student.id }));
};
</script>

<template>
    <Head title="Recommender" />

    <AdminLayout>
       
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
                        <TableHeaderCell>Application Form</TableHeaderCell>
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
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Pending
                             </div>
                            </TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('recommender.edit', student.id)"  class="text-green-400 hover:text-green-600">Check</Link>
                                <Link :href="route('recommender.update', student.id)" method="PUT" as="button" class="text-red-400 hover:text-red-600">Recommend</Link>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
        </div>
        </div>
</AdminLayout>
</template>
