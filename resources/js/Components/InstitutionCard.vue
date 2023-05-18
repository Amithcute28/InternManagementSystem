<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  institution: {
    type: Object,
    required: true,
  },
});

const handleClick = () => {
  // You can use the route function to generate a URL for the show method of the ReportsController,
  // which will display the recommended institutions for the student.
  window.location.href = route('reports.show', student.id);
};
</script>



<template>
  <div class="p-4 my-4 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-2">{{ institution.name }}</h2>
    <p>Required GPA: {{ institution.required_academic_performance }}</p>
  </div>

  <div>
  <button class="recommend-button" @click="handleClick">Recommend Institutions</button>
</div>
</template>

<style scoped>
.recommend-button {
  background-color: #4caf50;
  color: #fff;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
}
</style>