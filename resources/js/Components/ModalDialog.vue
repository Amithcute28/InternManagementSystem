<script setup>
defineEmits(["close-modal"]);

defineProps({
  modalActive: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <div
    v-show="modalActive"
    class="absolute w-full bg-black  modal-dialog-backdrop h-full top-0 left-0 flex justify-center items-center p-5 z-10"
  >
    <div v-if="modalActive" class="h-45 w-11/12 md:w-1/2 p-6 bg-white rounded-md modal-dialog-open">
     <div class="flex flex-col w-full h-auto ">
      <div class="flex justify-end">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-6 h-6 cursor-pointer"
          @click="$emit('close-modal')"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </div>
      <slot />
      </div>
    </div>
  </div>

  
<!-- <section class=" flex h-screen w-screen p-10 justify-center items-start">
  <button onclick="document.getElementById('myModal').showModal()" id="btn" class="py-3 px-10 bg-gray-800 text-white rounded text shadow-xl">Open</button>
</section> -->




</template>


<style>
 .modal-dialog-open {
    animation: appear .15s cubic-bezier(0, 1.8, 1, 1.8);
  }

  .modal-dialog-backdrop {
    background: linear-gradient(45deg, rgba(0, 0, 0, 0.5), rgba(54, 54, 54, 0.5));
    backdrop-filter: blur(3px);
  }

  @keyframes appear {
    from {
      opacity: 0;
      transform: translateX(-3rem);
    }

    to {
      opacity: 1;
      transform: translateX(0);
    }
  } 
</style>