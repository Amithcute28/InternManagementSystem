<script setup>
import { defineProps } from 'vue'

const props = defineProps({
  student: {
    type: Object,
    required: true,
  },
  schools: {
    type: Array,
    required: true,
  },
})
</script>

<template>
  <div>
    <h1>Recommended Schools</h1>
    <p>Based on your academic performance and your school's requirements, we recommend the following schools:</p>
    <ul>
      <li v-for="school in schools" :key="school.id">
        <h2>{{ school.name }}</h2>
        <p>{{ school.description }}</p>
        <p>Academic Performance: {{ school.academic_performance }}</p>
      </li>
    </ul>
  </div>
</template>