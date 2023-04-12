<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
<section class="flex flex-col md:flex-row h-screen items-center">

  <div class="bg-white-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
    <img src="@/Assets/logBack.png" alt="" class="w-full h-full object-cover">
  </div>

  <div class="bg-white w-20 md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
        flex items-center justify-center">

    <div class="w-80 h-100 ">

        <h1 class="text-4xl md:text-4xl font-bold leading-tight mt-12 flex justify-center">Hello,Again!</h1>

      <h1 class="text-xl md:text-1xl font-bold leading-tight mt-10">Log in to your account</h1>

      <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
          {{ status }}
      </div>

      <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
        <div>
          <label class="block text-gray-700">Email Address</label>
          <input 
          type="email" 
          name="" 
          id="email" 
          v-model="form.email"
          placeholder="Enter Email Address" 
          class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none" 
          autofocus 
          required 
          autocomplete="username">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
          <label class="block text-gray-700">Password</label>
          <input 
          type="password" 
          name="" 
          id="password" 
          v-model="form.password"
          placeholder="Enter Password" 
          minlength="6" class="w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500
                focus:bg-white focus:outline-none" 
          required
          autocomplete="current-password">
          <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="block mt-4 flex flex-wrap justify-between">
          <label>
              <Checkbox name="remember" v-model:checked="form.remember" />
              <a class="text-sm text-gray-700 pl-1">Remember me</a>
               
              
          </label>
          <Link
                  v-if="canResetPassword"
                  :href="route('password.request')"
                  class="text-sm text-gray-700 hover:text-blue-700"
              >
                  Forgot your password?
              </Link>
    
        </div>

            
 
        <button type="submit" class="w-80 py-2.5 block bg-indigo-500 hover:bg-indigo-400 focus:bg-indigo-400 text-white font-semibold rounded-lg
              px-4 py-3 mt-6" :class=" {'opacity-25': form.processing }" :disabled="form.processing">Log In</button>
      </form>

      


      <p class="mt-8 flex justify-center text-gray-700">Need an account?&nbsp;<a :href="route('register')" class="text-blue-500 hover:text-blue-700 font-semibold">Create an
              account</a></p>

    </div>
  </div>

</section>

</template>
