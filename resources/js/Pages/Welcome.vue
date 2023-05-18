<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Head title="Welcome" />

  <div
    class="bg-white relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
  >
    <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
      <Link
        v-if="$page.props.auth.user"
        :href="route('dashboard')"
        class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
        >Dashboard</Link
      >

      <template v-else>
        <Link
          :href="route('login')"
          class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800 rounded-lg mt-2 border focus:border-indigo-500"
          >Log in</Link
        >

        <Link
          v-if="canRegister"
          :href="route('register')"
          class="text-white bg-indigo-500 hover:bg-indigo-400 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
          >Register</Link
        >
      </template>
    </div>
    <!-- component -->
    <header id="header" class="header">
      <section
        class="bg-white h-screen px-4 md:px-12 lg:px-32 py-8 md:py-32 mb-8 flex flex-col md:flex-row md:items-center"
      >
        <!-- Main text start -->
        <div
          class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12"
        >
          <div class="mr-auto place-self-center lg:col-span-7">
            <h1
              class="max-w-xl mb-4 text-4xl uppercase font-semibold leading-none md:text-5xl xl:text-5xl dark:text-white"
            >
              Recommender and Management System
            </h1>
            <p
              class="max-w-sm mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400 text-left"
            >
              "Recommender and Management System" is a comparison of two
              different types of computer-based tools that serve distinct
              purposes. A Recommender System is a software tool that predicts or
              recommends items to users based on their past behavior or
              preferences. It is commonly used in e-commerce, social media, and
              entertainment applications to enhance the user experience by
              providing personalized recommendations.
            </p>
            <a
              :href="route('login')"
              class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-indigo-500 hover:bg-blue-400 focus:ring-4 focus:ring-blue-300 dark:focus:ring-indigo-900"
            >
              Get started
              <svg
                class="w-5 h-5 ml-2 -mr-1"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
          </div>
        </div>
        <div
          class="hidden lg:mt-0 lg:col-span-5 lg:flex absolute bottom-0 right-0 overflow-hidden h-2/5 sm:h-1/2 md:h-3/5 lg:h-4/6"
        >
          <img src="@/Assets/backg.png" alt="mockup" />
        </div>
        <!-- Photographer image end -->

        <!-- "More" button start -->

        <!-- "More" button end -->
      </section>

      <!-- Main section end -->
    </header>
  </div>
</template>

<style>
</style>
