<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';



</script>

<template>
    <Head title="Waiting for student to chooses" />

    <AdminLayout>
          <div class="mt-16">
             <Link :href="route('offcampus.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Back</Link>
        </div>
        
  <div class="relative bg-white px-6 pt-10 pb-9 shadow-md mx-auto w-full max-w-lg rounded-2xl h-80 mt-32 flex items-center overflow-hidden">
    <div class="mx-auto flex w-full max-w-md flex-col space-y-16">
      <div class="flex flex-col items-center justify-center text-center space-y-2">
        <div class="font-semibold text-3xl">
          <p>Waiting for the student to choose institution.</p>
        </div>
</div>
  </div>
</div>
    </AdminLayout>

  
</template>
