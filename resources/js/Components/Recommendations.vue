<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const matches = ref([]);

onMounted(async () => {
  const studentId = 1; // Replace with actual student ID
  const response = await axios.get(`/recommend?student_id=${studentId}`);
  matches.value = response.data;
});
</script>

<template>
  <div>
    <h1>Recommended Teaching Practices</h1>
    <ul>
      <li v-for="match in matches" :key="match.id">
        {{ match.title }}
      </li>
    </ul>
  </div>
</template>