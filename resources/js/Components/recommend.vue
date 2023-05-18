<template>
  <div>
    <h1>Recommended Institutions</h1>
    <ul>
      <li v-for="institution in institutions" :key="institution.id">
        {{ institution.name }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { reactive, onMounted } from 'vue'
import axios from 'axios'

const state = reactive({
  institutions: []
})

onMounted(async () => {
  const response = await axios.get('/recommend')
  state.institutions = response.data
})
</script>