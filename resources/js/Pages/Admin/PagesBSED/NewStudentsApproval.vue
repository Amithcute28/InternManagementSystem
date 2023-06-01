<script setup>
import AdminLayoutBSED from "@/Layouts/AdminLayoutBSED.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { ref } from "vue";

const step = ref(1);
const firstName = ref("");
const lastName = ref("");
const email = ref("");
const password = ref("");

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
  newstudentbsed: {
    type: Object,
    required: true,
  },
});
console.log(props.newstudent);

const form = useForm({
  student_id: props.newstudentbsed?.student_id,
  program: props.newstudentbsed?.program,
  full_name: props.newstudentbsed?.full_name,
  email: props.newstudentbsed?.email,
  approved: props.newstudentbsed?.approved,
});

const submit = () => {
  form.put(route("newstudentsbsed.update", props.newstudentbsed?.id));
};
</script>

<template>
  <AdminLayoutBSED>
    <Head title="Update student" />


<div class="bg-white pb-10 px-10 rounded-xl shadow-xl mt-16">
                    <div class="flex items-center justify-between  space-x-2 ml-3 font-semibold text-gray-900 leading-8">
                        <span class="tracking-wide">About</span>
                                    <Link :href="route('newstudentsbsed.index')" class=" px-3 text-white font-semibold bg-indigo-500 hover:bg-indigo-400 rounded m-4">Back</Link>       
                    </div>
                    <div class=" text-gray-700" >
                      
    <form @submit.prevent="submit" action="#" method="POST">
    <div class="mt-8">
         

           <div class="grid md:grid-cols-2 md:gap-6">
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

         
      </div> 
      <Link :href="route('newstudentsbsed.updateNewStudent', newstudentbsed.id)" method="PUT" as="button" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-gold hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">Approve</Link>
   <!-- <button type="submit" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">Approve</button> -->
 </form>                 
                        
                    </div>
                   
                         
                         
 



  

        </div>
    </AdminLayoutBSED>
</template>
