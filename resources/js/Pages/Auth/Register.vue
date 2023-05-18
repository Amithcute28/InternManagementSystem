<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
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

    const form = useForm({
        student_id: '',
        password: '',
        password_confirmation: '',
        year_level: '',
        full_name: '',
         academic_performance: '',
          program: '',
           skills: '',
        email: '',
        birthday: '',
        gender: '',
        relationship: '',
        nationality: '',
        contact_number: '',
        home_address: '',
        zip_code: '',
        guardian_name: '',
        guardian_contact: '',



      
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
    
       <div class="bg-white-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
    <img src="@/Assets/signup5.png" alt="" class="w-full h-full object-cover">
  </div>
    
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12 ">
     
      <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base mt-5 mb-20">
        <li :class="{'text-blue-600 dark:text-blue-500': step === 1, 'text-gray-400': step !== 1}">
          <span class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Account Info
          </span>
        </li>
        <li :class="{'text-blue-600 dark:text-blue-500': step === 2, 'text-gray-400': step !== 2}" class="mx-6 xl:mx-10">
           <span class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            </svg>
            Profile
          </span>
        </li>
        <li :class="{'text-blue-600 dark:text-blue-500': step === 3, 'text-gray-400': step !== 3}">
           <span class="flex items-center text-sm">
            <svg class="w-4 h-4 mr-2 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>

             
            Other Details
          </span>
        </li>
      </ol>


      <div class="mt-8">
        <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
          <div v-if="step === 1">

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
    type="password" 
    id="password" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.password"
    required
    autofocus
    autocomplete="password" />
    <label 
    for="password" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Password</label>
    <InputError class="mt-2" :message="form.errors.password" />
</div>

<div class="relative z-0 w-full mb-6 group">
    <input 
    type="password" 
    id="password_confirmation" 
    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
    placeholder=" "
    v-model="form.password_confirmation"
    required
    autofocus
    autocomplete="password_confirmation" />
    <label 
    for="password_confirmation" 
    class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Confirm Password</label>
    <InputError class="mt-2" :message="form.errors.password_confirmation" />
</div>

 <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="academic_performance"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.academic_performance"
                required
                autofocus
                autocomplete="academic_performance"
              />
              <label
                for="academic_performance"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Academic Performance</label
              >
              <InputError class="mt-2" :message="form.errors.academic_performance" />
            </div>

             

             <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="skills"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.skills"
                required
                autofocus
                autocomplete="skills"
              />
              <label
                for="skills"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Skills</label
              >
              <InputError class="mt-2" :message="form.errors.skills" />
            </div>
</div>

          <div v-if="step === 2">
           
               <div class="grid md:grid-cols-2 md:gap-6">
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

          </div>
          <div v-if="step === 3">
           
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
          <div class="flex justify-between mt-8">
            <button v-if="step > 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-600 dark:text-gray-200 py-2 px-4 rounded-lg" @click="prevStep">Previous</button>
            <button v-if="step < 3" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg" @click="nextStep">Next</button>
            <button v-if="step === 3" type="submit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg">Register</button>
          </div>
        </form>
         
      </div>
      <p class="inline-block align-bottom mt-8 flex justify-center text-gray-700">Already registered?&nbsp;<a :href="route('login')" class="text-blue-500 hover:text-blue-700 font-semibold">Login</a></p>
    </div>
    
    </section>

    
            
        
    </template>
    