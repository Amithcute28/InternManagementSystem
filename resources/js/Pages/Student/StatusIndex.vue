<script setup>
 import UserLayout from '@/Layouts/UserLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link} from "@inertiajs/vue3";
    import { defineProps } from 'vue';

    const props = defineProps({
        students: {
            type: Array,
            required: true,
        },
    });
</script>

<template>
    <Head title="Off Campus" />

    <UserLayout>
        <div class="mt-16 flex">

            <div class="w-full">
                <h1 class="text-xl font-bold mb-4">Students</h1>
                <div class="bg-white shadow-md rounded my-6">
                    <table class="w-full table-auto"> 
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                
                                <th class="py-3 px-4 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="student in students" :key="student.id" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4">
                                    <Link :href="route('status.show', { id: student.id })" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</Link>
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
        </div>
    </UserLayout>
</template>

