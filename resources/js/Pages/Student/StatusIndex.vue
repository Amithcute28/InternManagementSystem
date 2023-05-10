<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
</script>

<template>
  <Head title="Status" />

  <UserLayout>
    <div>
      <Link
        :href="route('status.create')"
        class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
        >Recommend</Link
      >
      <div
        class="flex h-screen flex-col items-center justify-center space-y-6 px-4 sm:flex-row sm:space-x-6 sm:space-y-0"
      >
        <div
          class="w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-md duration-300 hover:scale-105 hover:shadow-xl"
        >
          <!-- <svg
          xmlns="http://www.w3.org/2000/svg"
          class="mx-auto mt-8 h-16 w-16 text-red-500"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"
          />
        </svg> -->
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="mx-auto mt-8 h-16 w-16 text-orange-500"
          >
            <path
              fill-rule="evenodd"
              d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 01.67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 11-.671-1.34l.041-.022zM12 9a.75.75 0 100-1.5.75.75 0 000 1.5z"
              clip-rule="evenodd"
            />
          </svg>

          <h1 class="mt-2 text-center text-2xl font-bold text-gray-500">
            Application is pending
          </h1>
          <p class="my-4 text-center text-sm text-gray-500">
            always check your account to be updated
          </p>
          <div class="space-x-4 bg-gray-100 py-4 text-center"></div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>
