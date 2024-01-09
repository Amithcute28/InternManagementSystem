<script setup>
</script>
<template>
  <div class="relative overflow-auto shadow-md sm:rounded-lg bg-white">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead
        class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400"
      >
        <slot name="header"></slot>
        
      </thead>
      <tbody>
        <slot></slot>
      </tbody>
       <slot name="footer"></slot>
    </table>
  </div>
</template>