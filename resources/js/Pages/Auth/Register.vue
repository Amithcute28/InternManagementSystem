<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
        <Head title="Register" />
<section class="flex flex-col md:flex-row h-screen items-center">

  <div class="bg-indigo-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
    <img src="@/Assets/logBack.png" alt="" class="w-full h-full object-cover">
  </div>

  <div class="bg-white w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12
        flex items-center justify-center">

    <div class="w-80 h-100">


      <h1 class="flex justify-center text-xl md:text-2xl font-bold leading-tight mt-12">Create your account</h1>

      <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
        <div>
            <InputLabel for="name" value="Name" />

            <TextInput
                id="name"
                type="text"
                class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                placeholder="Name"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
            />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div class="mt-4">
            <InputLabel for="email" value="Email" />

            <TextInput
                id="email"
                type="email"
                class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                placeholder="Email"
                v-model="form.email"
                required
                autocomplete="username"
            />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="mt-4">
            <InputLabel for="password" value="Password" />

            <TextInput
                id="password"
                type="password"
                class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                placeholder="password"
                v-model="form.password"
                required
                autocomplete="new-password"
            />

            <InputError class="mt-2" :message="form.errors.password" />
        </div>

        <div class="mt-4">
            <InputLabel for="password_confirmation" value="Confirm Password" />

            <TextInput
                id="password_confirmation"
                type="password"
                class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                placeholder="Confirm password"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
                
            />

            <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>

        
            <button type="submit" class="w-80 py-2.5 block bg-indigo-500 hover:bg-indigo-400 focus:bg-indigo-400 text-white font-semibold rounded-lg
              px-4 py-3 mt-6">Register</button>

    </form>


      <p class="mt-8 flex justify-center text-gray-700">Already registered?&nbsp;<a :href="route('login')" class="text-blue-500 hover:text-blue-700 font-semibold" :class=" {'opacity-25': form.processing }" :disabled="form.processing">
              Login</a></p>


    </div>
  </div>

</section>
        
    
</template>
