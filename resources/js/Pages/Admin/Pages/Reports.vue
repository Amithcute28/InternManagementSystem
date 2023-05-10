<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

import { reactive } from 'vue';
import axios from 'axios';

const state = reactive({
  academicPerformance: 90,
  institutions: [],
});

const getRecommendations = async () => {
  try {
    const response = await axios.get('/recommendations', {
      params: {
        academic_performance: state.academicPerformance,
      },
    });
    state.institutions = response.data.institutions;
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
    <Head title="Reports" />

    <AdminLayout>
        <div class="mt-16">
    <h1>Students</h1>

    <div>
    <h1>Recommended Institutions</h1>
    <button @click="getRecommendations">Get Recommendations</button>
    <ul>
      <li v-for="institution in institutions" :key="institution.id">{{ institution.name }}</li>
    </ul>
  </div>
  </div>
    </AdminLayout>

</template>

