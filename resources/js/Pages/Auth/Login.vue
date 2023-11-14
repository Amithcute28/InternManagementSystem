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
    <img src="@/Assets/loginlogo41.jpg" alt="" class="w-full h-full object-cover">
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
        
        <div class="relative">
    <input 
          type="email" 
          name="" 
          id="email" 
          v-model="form.email"
          class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
          placeholder=" "
       
          required 
          autocomplete="username">
          <InputError class="mt-2" :message="form.errors.email" />
    <label for="floating_outlined" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email address</label>
</div>

<div class="relative mt-4">
    <input 
          type="password" 
          name="" 
          id="password" 
          v-model="form.password"
          class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-500 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
          placeholder=" " 
          
          required 
          autocomplete="current-password">
          <InputError class="mt-2" :message="form.errors.password" />
    <label for="floating_outlined" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
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

            
 
        <button type="submit" class="w-80 py-2.5 block bg-gold hover:bg-indigo-400 focus:bg-indigo-400 text-white font-semibold rounded-lg
              px-4 py-3 mt-6" :class=" {'opacity-25': form.processing }" :disabled="form.processing">Log In</button>
      </form>

      


      <p class="mt-8 flex justify-center text-gray-700">Need an account?&nbsp;<a :href="route('register')" class="text-blue-500 hover:text-blue-700 font-semibold">Create an
              account</a></p>

    </div>
  </div>

</section>

</template>
