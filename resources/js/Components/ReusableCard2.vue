<script setup>
</script>
<template>
  <div
    class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xxl:col-span-6"
  >
    <!-- Start Nav Bar -->
   <div
                class="relative w-full group max-w-md min-w-0 mx-auto mt-6 mb-6 break-words bg-white border shadow-2xl dark:bg-gray-800 dark:border-gray-700 md:max-w-sm rounded-xl"
              >
                <div class="pb-6">
                  <div class="flex flex-wrap justify-center">
                    <div class="flex justify-center w-full">
                      <div class="relative">
                        <img
                          src="@/Assets/maamAriaso.jpg"
                          class="dark:shadow-xl border-white dark:border-gray-800 rounded-full align-middle border-8 absolute -m-16 -ml-18 lg:-ml-16 max-w-[150px]"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="mt-2 mt-20 text-center">
                     <div class="flex space-x-6 items-center">
        <slot></slot>
      </div>
                  </div>
                 
                  <div
                    class="relative h-6 overflow-hidden translate-y-6 rounded-b-xl"
                  >
                    <div class="absolute flex -space-x-12 rounded-b-2xl">
                      <div
                        class="w-36 h-8 transition-colors duration-200 delay-75 transform skew-x-[35deg] bg-amber-400/90 group-hover:bg-amber-600/90 z-10"
                      ></div>
                      <div
                        class="w-28 h-8 transition-colors duration-200 delay-100 transform skew-x-[35deg] bg-amber-300/90 group-hover:bg-amber-500/90 z-20"
                      ></div>
                      <div
                        class="w-28 h-8 transition-colors duration-200 delay-150 transform skew-x-[35deg] bg-amber-200/90 group-hover:bg-amber-400/90 z-30"
                      ></div>
                      <div
                        class="w-28 h-8 transition-colors duration-200 delay-200 transform skew-x-[35deg] bg-amber-100/90 group-hover:bg-amber-300/90 z-40"
                      ></div>
                      <div
                        class="w-28 h-8 transition-colors duration-200 delay-300 transform skew-x-[35deg] bg-amber-50/90 group-hover:bg-amber-200/90 z-50"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
  </div>
  <!-- End Nav Bar -->
</template>