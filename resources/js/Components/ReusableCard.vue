<script setup>
</script>
<template>
  <div
    class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xxl:col-span-6"
  >
    <!-- Start Nav Bar -->
    <div
      class="bg-white p-5 rounded-xl shadow-xl flex items-center justify-between mt-4 transform hover:scale-105 transition duration-300 shadow-xl rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
    >
      <div class="flex space-x-6 items-center">
        <slot></slot>
      </div>
    </div>
  </div>
  <!-- End Nav Bar -->
</template>