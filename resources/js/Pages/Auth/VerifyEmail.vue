<script setup>
import { computed } from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);
</script>

<template>
  <nav class="bg-blue border-b-2 border-gold">
    <div class="max-w-7xl mx-auto px-6 md:px-14">
      <div class="flex justify-between items-center space-x-32">
        <!-- logo -->
        <div class="flex items-center space-x-4">
          <a
            href="#home"
            class="block text-white text-lg font-extrabold flex items-center py-3 px-2"
          >
            <img src="@/Assets/logo.png" class="w-12 h-12 mr-3" />
            <span>Prac<span class="text-yellow-400">Teach.</span></span>
          </a>
          <h1 class="font-bold text-xl text-white uppercase">
            EMAIL VERIFICATION NOTICE
          </h1>
        </div>

        <!-- primary nav -->
        <div class="hidden md:flex items-center space-x-2"></div>

        <!-- login button for big screen -->
        <div class="flex items-center space-x-1">
          <div>
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="font-bold py-2 px-3 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out"
              >Log out</Link
            >
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
  <section
    id="home"
    class="bg-[linear-gradient(to_right,rgba(7,36,155,0.9),rgba(19,26,230,0)),url('/resources/js/assets/PracticeMe.jpg')] bg-cover bg-center bg-fixed w-full h-screen flex items-center"
  >
    <div class="text-white px-4 sm:px-8 md:px-16">
      <h1 class="text-2xl sm:text-4xl md:text-6xl font-extrabold">
        |
        <span class="text-yellow-300"> THANKS FOR SIGNING UP! </span>
      </h1>
      <p class="py-4 sm:py-6 text-base sm:text-2xl">
        Please verify your email by clicking the link we sent. <br />
        If you didn't get it, click resend
      </p>

      <p
        v-if="verificationLinkSent"
        class="font-medium mb-6 text-base text-green-300"
      >
        A new verification link has been sent to the email address <br />
        you provided during registration.
      </p>

      <a
        @click="submit"
        class="font-bold py-4 px-10 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out cursor-pointer"
        >Resend Verification Email</a
      >
    </div>
  </section>
  <GuestLayout>
    <Head title="Email Verification" />

    <div class="mb-4 text-sm text-gray-600">
      Thanks for signing up! Before getting started, could you verify your email
      address by clicking on the link we just emailed to you? If you didn't
      receive the email, we will gladly send you another.
    </div>

    <div
      class="mb-4 font-medium text-sm text-green-600"
      v-if="verificationLinkSent"
    >
      A new verification link has been sent to the email address you provided
      during registration.
    </div>

    <form @submit.prevent="submit">
      <div class="mt-4 flex items-center justify-between">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Resend Verification Email
        </PrimaryButton>
      </div>
    </form>
  </GuestLayout>
</template>
