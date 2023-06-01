<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    
import { ref } from 'vue';



const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  skills: '',
  birthday: '',
  gender: '',
  relationship: '',
  nationality: '',
  contact_number: '',
  home_address: '',
  zip_code: '',
  guardian_name: '',
  guardian_contact: '',
  profile: '',
  terms: false,
});
    
 const submit = () => {
  form.post(route("user.updateNewIntern", props.user?.id), {
_method: 'put',
  });
};


    </script>
<template>
<div class="flex items-center justify-center mt-16">
    <div class="mt-8">
      <h1>New intern, Please fill up the required information to continue!</h1>
      <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
            <div class="grid md:grid-cols-2 md:gap-6">
         

          
            





             

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
        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Relationship status</label>
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
 <div class="sm:col-span-2">
                <label
                  for="profile"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Profile Picture</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="profile"
                      name="profile"
                      type="file"
                      @input="form.profile = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                   
                  </label>
                </div>
              </div>


         
            </div>
             <button type="submit" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-gold hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">
          Submit
        </button>
        </form>
         
      </div>
    </div>
</template>