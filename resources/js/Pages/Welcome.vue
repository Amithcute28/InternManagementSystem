<script setup>
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

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

  <div class="relative min-h-screen">
    <nav class="bg-blue border-b-2 border-gold">
      <div class="max-w-7xl mx-auto px-6 md:px-14">
        <div class="flex justify-between">
          <!-- logo -->
          <div>
            <a
              href="#home"
              class="block text-white text-lg font-extrabold flex items-center py-3 px-2"
            >
              <img src="@/Assets/logo.png" class="w-12 h-12 mr-3" />
              <span>Prac<span class="text-yellow-400">Teach.</span></span>
            </a>
          </div>

          <!-- primary nav -->
          <div class="hidden md:flex flex items-center space-x-4">
            <a
              href="#home"
              class="text-gray-100 hover:font-bold py-4 px-3 hover:text-gold transition duration-200 ease-in-out"
              >Home</a
            >
            <a
              href="#aboutUs"
              class="text-gray-100 hover:font-bold py-4 px-3 hover:text-gold transition duration-200 ease-in-out"
              >About Us</a
            >
            <a
              href="#coordinators"
              class="text-gray-100 hover:font-bold py-4 px-3 hover:text-gold transition duration-200 ease-in-out"
              >Coordinators</a
            >

            <a
              href="#interns"
              class="text-gray-100 hover:font-bold py-4 px-3 hover:text-gold transition duration-200 ease-in-out"
              >Interns</a
            >
            <a
              href="#technicalSupport"
              class="text-gray-100 hover:font-bold py-4 px-3 hover:text-gold transition duration-200 ease-in-out"
              >Technical Support</a
            >
          </div>

          <!-- login button for big screen -->
          <div class="flex items-center space-x-1">
            <div v-if="canLogin">
              <a
                :href="route('dashboard')"
                v-if="$page.props.auth.user"
                class="text-gray-100 py-2 px-3"
                >Dashboard</a
              >
              <template v-else>
                <a :href="route('login')" class="text-gray-100 py-2 px-3"
                  >Login</a
                >
                <a
                  v-if="canRegister"
                  :href="route('register')"
                  class="font-bold py-2 px-3 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out"
                  >Register</a
                >
              </template>
            </div>

            <button class="p-4 focus:outline-none focus:bg-blue-200 md:hidden">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- sidebar -->
    <div
      class="bg-blue-900 text-blue-100 w-64 px-4 py-10 absolute inset-y-0 left-0 transform -translate-x-full z-20 transition duration-200 ease-in-out"
    >
      <!-- logo -->
      <a href="#" class="flex justify-center items-center space-x-2">
        <img src="@/Assets/logo.png" class="w-12 h-12" />
      </a>
      <p class="text-center text-lg font-extrabold mb-6 py-2">
        Leyte Normal University
      </p>

      <!-- nav -->

      <nav>
        <a
          href=""
          class="block py-2.5 px-4 my-2 hover:bg-yellow-500 rounded transition duration-200 ease-in-out"
          >Home</a
        ><a
          href=""
          class="block py-2.5 px-4 my-2 hover:bg-yellow-500 rounded transition duration-200 ease-in-out"
          >About Us</a
        ><a
          href=""
          class="block py-2.5 px-4 my-2 hover:bg-yellow-500 rounded transition duration-200 ease-in-out"
          >Interns</a
        ><a
          href=""
          class="block py-2.5 px-4 my-2 hover:bg-yellow-500 rounded transition duration-200 ease-in-out"
          >Developer</a
        >
      </nav>
    </div>

    <!-- content -->
    <section
      id="home"
      class="bg-[linear-gradient(to_right,rgba(7,36,155,0.9),rgba(19,26,230,0)),url('/resources/js/assets/lnubg.jpg')] bg-cover bg-center bg-fixed w-full h-screen flex items-center"
    >
      <div class="text-white px-4 sm:px-8 md:px-16">
        <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold">
          INTERNSHIP <br />
          <span class="text-yellow-400"> RECOMMENDER </span> AND <br />
          <span class="text-yellow-400"> MANAGEMENT SYSTEM </span>
        </h1>
        <p class="py-4 sm:py-6 mb-5 text-base sm:text-2xl">
          Unlock Your Teaching Potential with our Innovative Internship
          <br />
          Recommender and Management System
        </p>

        <a
          :href="route('login')"
          class="font-bold py-4 px-10 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out"
          >Get Started</a
        >
      </div>
    </section>
    <section id="aboutUs" class="py-10 bg-white sm:py-16 lg:py-24">
      <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
        <h1
          class="mb-5 flex justify-center text-3xl sm:text-4xl lg:text-5xl font-extrabold"
        >
          ABOUT US
        </h1>
        <div class="w-1/6 mx-auto mb-12">
          <hr class="border-t-4 border-gold mb-8" />
        </div>
        <div>
          <div class="grid items-center md:grid-cols-2 gap-y-10 md:gap-x-20">
            <div class="pr-12 sm:pr-0">
              <div class="relative max-w-2xl mb-12">
                <img
                  class="object-bottom rounded-md"
                  src="@/assets/beed.jpg"
                  alt=""
                />

                <img
                  class="absolute origin-bottom-right scale-75 rounded-md -bottom-12 -right-12"
                  src="@/assets/bsed.jpg"
                  alt=""
                />
              </div>
            </div>

            <div>
              <h2
                class="text-3xl font-medium leading-tight text-black sm:text-4xl lg:text-5xl"
              >
                Unleash Your Teaching Superpowers.
              </h2>
              <p class="mt-4 text-base leading-relaxed text-gray-600">
                Our platform empowers educators with personalized
                recommendations, streamlined management tools, and a
                transformative impact on student learning. Join
                <b>PracTeach</b> and unlock your teaching potential to create
                extraordinary educational experiences that shape young minds for
                a brighter future. Together, let's revolutionize the way we
                teach and inspire the next generation of learners.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section
      id="coordinators"
      class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20"
    >
      <div class="mx-auto mb-10 lg:max-w-xl sm:text-center">
        <h1
          class="mb-5 flex justify-center text-3xl sm:text-4xl lg:text-5xl font-extrabold"
        >
          Coordinators
        </h1>
        <div class="w-1/6 mx-auto mb-12">
          <hr class="border-t-4 border-gold mb-8" />
        </div>
      </div>
      <div class="px-6 pt-6 2xl:container">
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-2">
          <div class="md:col-span-2 lg:col-span-1">
            <!-- component -->
            <!-- This is an example component -->

            <div
              class="relative w-full group max-w-md min-w-0 mx-auto mt-6 mb-6 break-words bg-white border shadow-2xl dark:bg-gray-800 dark:border-gray-700 md:max-w-sm rounded-xl hover:scale-110 transition duration-200 ease-in-out"
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
                  <h3
                    class="mb-1 text-2xl font-bold leading-normal text-gray-700 dark:text-gray-300"
                  >
                    Rowena N. Ariaso Ed.D.
                  </h3>
                  <div
                    class="flex flex-row justify-center w-full mx-auto space-x-2 text-center"
                  >
                    <!-- /typography/_h3.antlers.html -->
                    <div
                      class="text-sm font-bold tracking-wide text-gray-600 dark:text-gray-300 font-mono text-xl"
                    >
                      BEED, Internship Coordinator
                    </div>
                    <!-- End: /typography/_h3.antlers.html -->
                  </div>
                  <div class="w-full text-center">
                    <div class="flex justify-center pt-8 pb-0 lg:pt-4"></div>
                  </div>
                </div>
                <div
                  class="pt-6 mx-6 mt-6 text-center border-t border-gray-200 dark:border-gray-700/50"
                >
                  <div class="flex flex-wrap justify-center">
                    <div class="w-full px-6">
                      <p
                        class="mb-4 font-light leading-relaxed text-gray-600 dark:text-gray-400"
                      ></p>
                    </div>
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

          <div
            class="relative w-full group max-w-md min-w-0 mx-auto mt-6 mb-6 break-words bg-white border shadow-2xl dark:bg-gray-800 dark:border-gray-700 md:max-w-sm rounded-xl hover:scale-110 transition duration-200 ease-in-out"
          >
            <div class="pb-6">
              <div class="flex flex-wrap justify-center">
                <div class="flex justify-center w-full">
                  <div class="relative">
                    <img
                      src="@/Assets/maamtan.jpg"
                      class="dark:shadow-xl border-white dark:border-gray-800 rounded-full align-middle border-8 absolute -m-16 -ml-18 lg:-ml-16 max-w-[150px]"
                    />
                  </div>
                </div>
              </div>
              <div class="mt-2 mt-20 text-center">
                <h3
                  class="mb-1 text-2xl font-bold leading-normal text-gray-700 dark:text-gray-300"
                >
                  Maria Lourdes G. Tan. Ed.D.
                </h3>
                <div
                  class="flex flex-row justify-center w-full mx-auto space-x-2 text-center"
                >
                  <!-- /typography/_h3.antlers.html -->
                  <div
                    class="text-sm font-bold tracking-wide text-gray-600 dark:text-gray-300 font-mono text-xl"
                  >
                    BSED, Internship Coordinator
                  </div>
                  <!-- End: /typography/_h3.antlers.html -->
                </div>
                <div class="w-full text-center">
                  <div class="flex justify-center pt-8 pb-0 lg:pt-4"></div>
                </div>
              </div>
              <div
                class="pt-6 mx-6 mt-6 text-center border-t border-gray-200 dark:border-gray-700/50"
              >
                <div class="flex flex-wrap justify-center">
                  <div class="w-full px-6">
                    <p
                      class="mb-4 font-light leading-relaxed text-gray-600 dark:text-gray-400"
                    ></p>
                  </div>
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
      </div>
    </section>

    <section
      id="interns"
      class="bg-[linear-gradient(to_right,rgba(200,170,9,0.9),rgba(7,36,155,0.9)),url('/resources/js/assets/interns.jpg')] text-white bg-cover bg-center bg-fixed w-full h-96 flex items-center justify-evenly"
    >
      <div>
        <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold">BEED</h1>
        <p class="py-6 text-5xl">105</p>
      </div>
      <div>
        <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold">BSED</h1>
        <p class="py-6 text-5xl">155</p>
      </div>
      <div>
        <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold">
          Total Interns
        </h1>
        <p class="py-6 text-5xl">260</p>
      </div>
    </section>

    <section
      id="technicalSupport"
      class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20"
    >
      <div class="mx-auto mb-10 lg:max-w-xl sm:text-center">
        <h1
          class="mb-5 flex justify-center text-3xl sm:text-4xl lg:text-5xl font-extrabold"
        >
          TECHNICAL SUPPORT
        </h1>
        <div class="w-1/6 mx-auto mb-12">
          <hr class="border-t-4 border-gold mb-8" />
        </div>
      </div>
      <div
        class="grid gap-10 mx-auto sm:grid-cols-2 lg:grid-cols-4 lg:max-w-screen-lg"
      >
        <div>
          <div
            class="relative pb-56 mb-7 rounded lg:pb-64 shadow hover:shadow-lg hover:shadow-gold/80 hover:scale-110 transition duration-200 ease-in-out"
          >
            <img
              class="absolute object-cover w-full h-full rounded"
              src="@/assets/feli.png"
              alt="Person"
            />
          </div>
          <div class="flex flex-col sm:text-center">
            <p class="text-lg font-bold">Arvin Felicen</p>
            <p class="mb-5 text-xs text-gray-800">Fullstack Developer</p>
            <div class="flex items-center space-x-3 sm:justify-center">
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"
                  ></path>
                </svg>
              </a>
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div>
          <div
            class="relative pb-56 mb-7 rounded shadow lg:pb-64 hover:shadow-lg hover:shadow-blue/80 hover:scale-110 transition duration-200 ease-in-out"
          >
            <img
              class="absolute object-cover w-full h-full rounded"
              src="@/assets/amith.jpg"
              alt="Person"
            />
          </div>
          <div class="flex flex-col sm:text-center">
            <p class="text-lg font-bold">John Rey Amith</p>
            <p class="mb-5 text-xs text-gray-800">Fullstack Developer</p>
            <div class="flex items-center space-x-3 sm:justify-center">
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"
                  ></path>
                </svg>
              </a>
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div>
          <div
            class="relative pb-56 mb-7 rounded shadow lg:pb-64 hover:shadow-lg hover:shadow-gold/80 hover:scale-110 transition duration-200 ease-in-out"
          >
            <img
              class="absolute object-cover w-full h-full rounded"
              src="@/assets/adrian.jpg"
              alt="Person"
            />
          </div>
          <div class="flex flex-col sm:text-center">
            <p class="text-lg font-bold">Mark Adrian Dela Peña</p>
            <p class="mb-5 text-xs text-gray-800">Quality Assurance</p>
            <div class="flex items-center space-x-3 sm:justify-center">
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"
                  ></path>
                </svg>
              </a>
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div>
          <div
            class="relative pb-56 mb-7 rounded shadow lg:pb-64 hover:shadow-lg hover:shadow-blue/80 hover:scale-110 transition duration-200 ease-in-out"
          >
            <img
              class="absolute object-cover w-full h-full rounded"
              src="@/assets/heriaa.jpg"
              alt="Person"
            />
          </div>
          <div class="flex flex-col sm:text-center">
            <p class="text-lg font-bold">Joshua Raphaele Heria</p>
            <p class="mb-5 text-xs text-gray-800">Frontend Developer</p>
            <div class="flex items-center space-x-3 sm:justify-center">
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z"
                  ></path>
                </svg>
              </a>
              <a
                href="/"
                class="text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400"
              >
                <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                  <path
                    d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z"
                  ></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer aria-label="Site Footer" class="bg-blue">
      <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex justify-center text-teal-600">
          <div>
            <a
              href=""
              class="block text-white text-lg font-extrabold flex items-center py-3 px-2"
            >
              <img src="@/Assets/logo.png" class="w-12 h-12 mr-3" />
              <span>Leyte Normal University</span>
            </a>
          </div>
        </div>

        <p
          class="mx-auto mt-6 max-w-md text-center leading-relaxed text-gray-100"
        >
          To produce world-class educators and education leaders imbued with
          research capabilities, ideals, aspirations, values, and traditions of
          Philippine life who can adapt to the challenges of the world.
        </p>

        <nav aria-label="Footer Nav" class="mt-12">
          <ul class="flex flex-wrap justify-center gap-6 md:gap-8 lg:gap-12">
            <li>
              <a
                class="text-gray-100 transition hover:text-gray-700/75"
                href="#home"
              >
                Home
              </a>
            </li>

            <li>
              <a
                class="text-gray-100 transition hover:text-gray-700/75"
                href="#aboutUs"
              >
                About Us
              </a>
            </li>

            <li>
              <a
                class="text-gray-100 transition hover:text-gray-700/75"
                href="#coordinators"
              >
                Coordinators
              </a>
            </li>

            <li>
              <a
                class="text-gray-100 transition hover:text-gray-700/75"
                href="#interns"
              >
                Interns
              </a>
            </li>
            <li>
              <a
                class="text-gray-100 transition hover:text-gray-700/75"
                href="#technicalSupport"
              >
                Technical Support
              </a>
            </li>
          </ul>
        </nav>

        <ul class="mt-12 flex justify-center gap-6 md:gap-8">
          <li>
            <a
              href="/"
              rel="noreferrer"
              target="_blank"
              class="text-gray-100 transition hover:text-gray-700/75"
            >
              <span class="sr-only">Facebook</span>
              <svg
                class="h-6 w-6"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
          </li>

          <li>
            <a
              href="/"
              rel="noreferrer"
              target="_blank"
              class="text-gray-100 transition hover:text-gray-700/75"
            >
              <span class="sr-only">Instagram</span>
              <svg
                class="h-6 w-6"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  fill-rule="evenodd"
                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                  clip-rule="evenodd"
                />
              </svg>
            </a>
          </li>

          <li>
            <a
              href="/"
              rel="noreferrer"
              target="_blank"
              class="text-gray-100 transition hover:text-gray-700/75"
            >
              <span class="sr-only">Twitter</span>
              <svg
                class="h-6 w-6"
                fill="currentColor"
                viewBox="0 0 24 24"
                aria-hidden="true"
              >
                <path
                  d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"
                />
              </svg>
            </a>
          </li>
        </ul>
      </div>
    </footer>
    <div
      class="sticky bottom-0 left-0 w-full bg-blue text-white z-10 p-2 flex justify-center"
    >
      <h4 class="font-bold uppercase">
        Website <a class="underline decoration-gold">Under Development</a>
      </h4>
    </div>
  </div>
</template>

<style>
</style>
