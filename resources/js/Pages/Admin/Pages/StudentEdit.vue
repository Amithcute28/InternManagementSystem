<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';

const step = ref(1);
const firstName = ref('');
const lastName = ref('');
const email = ref('');
const password = ref('');

function nextStep() {
  step.value++;
}

function prevStep() {
  step.value--;
}

function submitForm() {
// Submit form logic goes her
}

const props = defineProps({
    student: {
        type: Object,
        required: true
    }
})

const form = useForm({
        student_id: props.student?.student_id,
        program: props.student?.program,
        year_level: props.student?.year_level,
        full_name: props.student?.full_name,
        email: props.student?.email,
        birthday: props.student?.birthday,
        gender: props.student?.gender,
        relationship: props.student?.relationship,
        nationality: props.student?.nationality,
        contact_number: props.student?.contact_number,
        home_address: props.student?.home_address,
        zip_code: props.student?.zip_code,
        guardian_name: props.student?.guardian_name,
        guardian_contact: props.student?.guardian_name,
        approved: props.student?.approved,
})

const submit = () => {
    form.put(route("students.update", props.student?.id));
};
</script>

<template>
<AdminLayout>
        <Head title="Update student" />


<div class="bg-white pb-10 px-10 rounded-xl shadow-xl mt-16">
                    <div class="flex items-center justify-between  space-x-2 ml-3 font-semibold text-gray-900 leading-8">
                        <span class="tracking-wide">About</span>
                                    <Link :href="route('students.index')" class=" px-3 text-white font-semibold bg-indigo-500 hover:bg-indigo-400 rounded m-4">Back</Link>       
                    </div>
                    <div class=" text-gray-700" >
                      
    <form @submit.prevent="submit" action="#" method="POST">
    <div class="grid md:grid-cols-2 text-sm md:gap-x-4 md:gap-y-2 ">

    <div class="relative z-0 w-full mb-6 group">
    <input 
    type="text" 
    id="student_id" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.student_id"
    required
    autofocus
    autocomplete="student_id" />
    <label 
    for="student_id" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Student ID</label>
    <InputError class="mt-2" :message="form.errors.student_id" />
    </div>

    <div class="grid md:grid-cols-2 md:gap-4">
    <div class="relative z-0 w-full mb-6 group">
        <input 
        type="text" 
        id="program" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.program"
        required
        autofocus
        autocomplete="program" />
        <label 
        for="program" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Program</label>
        <InputError class="mt-2" :message="form.errors.program" />
    </div>
    <div class="relative z-0 w-full mb-6 group">
       <input 
        type="text" 
        id="year_level" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.year_level"
        required
        autofocus
        autocomplete="year_level" />
        <label 
        for="year_level" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Year Level</label>
        <InputError class="mt-2" :message="form.errors.year_level" />
    </div>
  </div>

          
              <div class="relative z-0 w-full mb-6 group">
    <input 
    type="text" 
    id="full_name" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.full_name"
    required
    autofocus
    autocomplete="full_name" />
    <label 
    for="full_name" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Full Name</label>
    <InputError class="mt-2" :message="form.errors.full_name" />
</div>

            
              <div class="relative z-0 w-full mb-6 group">
    <input 
     type="email" 
    id="email" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.email"
    required
    autofocus
    autocomplete="email" />
    <label 
    for="email" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Email Address</label>
    <InputError class="mt-2" :message="form.errors.email" />
</div>


              <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-6 group">
        <input 
        type="text" 
        id="birthday" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.birthday"
        required
        autofocus
        autocomplete="birthday" />
        <label 
        for="birthday" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Birthday</label>
        <InputError class="mt-2" :message="form.errors.birthday" />
    </div>
    <div class="relative z-0 w-full mb-6 group">
       <input 
       type="text" 
        id="gender" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.gender"
        required
        autofocus
        autocomplete="gender" />
        <label 
        for="gender" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Gender</label>
        <InputError class="mt-2" :message="form.errors.gender" />
    </div>
  </div>

         <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-6 group">
        <input 
       type="text" 
        id="relationship" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.relationship"
        required
        autofocus
        autocomplete="relationship" />
        <label 
        for="relationship" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Relationship</label>
        <InputError class="mt-2" :message="form.errors.relationship" />
    </div>
    <div class="relative z-0 w-full mb-6 group">
       <input 
       type="text" 
        id="nationality" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.nationality"
        required
        autofocus
        autocomplete="nationality" />
        <label 
        for="nationality" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Nationality</label>
        <InputError class="mt-2" :message="form.errors.nationality" />
    </div>
  </div>

  <div class="grid md:grid-cols-2 md:gap-6">
    <div class="relative z-0 w-full mb-6 group">
        <input 
       type="text" 
        id="contact_number" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.contact_number"
        required
        autofocus
        autocomplete="contact_number" />
        <label 
        for="contact_number" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Contact Number</label>
        <InputError class="mt-2" :message="form.errors.contact_number" />
    </div>
    <div class="relative z-0 w-full mb-6 group">
       <input 
       type="text" 
        id="zip_code" 
        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
        placeholder=" "
        v-model="form.zip_code"
        required
        autofocus
        autocomplete="zip_code" />
        <label 
        for="zip_code" 
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Zip Code</label>
        <InputError class="mt-2" :message="form.errors.zip_code" />
    </div>
  </div>
            
            <div class="relative z-0 w-full mb-6 group">
    <input 
     type="text" 
    id="home_address" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.home_address"
    required
    autofocus
    autocomplete="home_address" />
    <label 
    for="home_address" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Home Address</label>
    <InputError class="mt-2" :message="form.errors.home_address" />
</div>


<div class="relative z-0 w-full mb-6 group">
    <input 
     type="text" 
    id="guardian_name" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.guardian_name"
    required
    autofocus
    autocomplete="guardian_name" />
    <label 
    for="guardian_name" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Guardian Name</label>
    <InputError class="mt-2" :message="form.errors.guardian_name" />
</div>

<div class="relative z-0 w-full mb-6 group">
    <input 
     type="text" 
    id="guardian_contact" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.guardian_contact"
    required
    autofocus
    autocomplete="guardian_contact" />
    <label 
    for="guardian_contact" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Guardian Contact Number</label>
    <InputError class="mt-2" :message="form.errors.guardian_contact" />
</div>


   </div>   
   <button type="submit" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">Update students</button>
 </form>                 
                        
                    </div>
                   
                         
                         
 



  

        </div>
    </AdminLayout>
</template>
