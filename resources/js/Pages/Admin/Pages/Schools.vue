<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import ReusableCard from '@/Components/ReusableCard.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ModalDialog from '@/Components/ModalDialog.vue';
import Arrow from '@/Components/Arrow.vue';
import { Head } from '@inertiajs/vue3';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from "vue";

const props = defineProps ({
    schools: Array
});


const modalActive = ref(null);
const toggleModal = () => {
    modalActive.value = !modalActive.value;
}

const form = useForm({
    schoolName: '',
    schoolAddress: '',
    schoolLogo: null,
   
});

const submit = () => {
  let formData = new FormData();
  formData.append('schoolName', form.schoolName);
  formData.append('schoolAddress', form.schoolAddress);
  formData.append('schoolLogo', form.schoolLogo);

  form.post(route('schools.store'), formData, {
    onFinish: () => form.reset('schoolName', 'schoolAddress', 'schoolLogo'),
  });
};



</script>


<template>
    <Head title="Schools" />

    <AdminLayout>

      
<div class="h-full mt-16">
    <div class="flex justify-end">
            
            <!-- <Link :href="route('schools.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded" @click="toggleModal" @close-modal="toggleModal">Add New School</Link> -->
             <PrimaryButton class="px-3 py-2 mx-6 text-white font-semibold rounded" @click="toggleModal" >Add New School</PrimaryButton>
           </div>
        <div class="grid grid-cols-2 gap-0">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                <div class="grid grid-cols-12 gap-6 ">
                    <ReusableCard v-for="school in schools" :key="school.id">
                       
                        <img :src="school.school_logo" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">{{ school.school_name }}</p>
                            <p class="font-semibold text-sm text-gray-400">{{ school.school_address }}</p>
                           <PrimaryButton ><template #icon>  <Arrow></Arrow> </template>  Read More</PrimaryButton>
                        </div> 

                    </ReusableCard>
                     <ModalDialog :modalActive="modalActive" @close-modal="toggleModal">
                        

    <form
      class="py-2 "
      @submit.prevent="submit"
      action="https://formbold.com/s/FORM_ID"
      method="POST"
    >
      <div class="grid grid-cols-2 gap-5">
  <div class="col-span-1 mb-5">
    <label for="schoolName" class="mb-3 block text-base font-medium text-[#07074D]">
      School Name:
    </label>
    <input type="text" v-model="form.schoolName" name="schoolName" id="schoolName" placeholder="Name of the School" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
  <div class="col-span-1 mb-5">
    <label for="schoolName" class="mb-3 block text-base font-medium text-[#07074D]">
      School Address:
    </label>
    <input type="text" v-model="form.schoolAddress" name="schoolAddress" id="schoolAddress" placeholder="Address of the school" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
</div>

      <div class="mb-6 pt-4">
        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
          Upload Logo
        </label>

        <div class="mb-8">
          <input type="file"  @input="form.schoolLogo = $event.target.files[0]" name="schoolLogo" id="schoolLogo" class="sr-only" />
          <label
            for="schoolLogo"
            class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center"
          >
            <div>
              <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                Drop files here
              </span>
              <span class="mb-2 block text-base font-medium text-[#6B7280]">
                Or
              </span>
              <span
                class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]"
              >
                Browse
              </span>
            </div>
          </label>
        </div>

        <div class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8" v-if="form.schoolLogo">
          <div class="flex items-center justify-between">
            <span class="truncate pr-3 text-base font-medium text-[#07074D]">
              {{ form.schoolLogo.name }}
            </span>
            <button class="text-[#07074D]">
              <svg
                width="10"
                height="10"
                viewBox="0 0 10 10"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                  fill="currentColor"
                />
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                  fill="currentColor"
                />
              </svg>
            </button>
          </div>
        </div>

        
      </div>

      <div>
        <button
         type="submit" class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
        >
          Add School
        </button>
      </div>
    </form>
    
 
                    </ModalDialog>

                    
                    <!-- <div class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xxl:col-span-6">
                        
                        <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between mt-4">
                    <div class="flex space-x-6 items-center">
                        <img src="@/Assets/logo.png" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">Leyte Normal University</p>
                            <p class="font-semibold text-sm text-gray-400">A leading university of education and diverse disciplines attuned to local and global development ne</p>
                            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5">
            Read more
            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </a>
                        </div>              
                    </div>
                       
                    <div class="flex space-x-2 items-center">
                        <div class="bg-gray-300 rounded-md p-2 flex items-center">
                            <i class="fas fa-chevron-right fa-sm text-black"></i>
                        </div>
                    </div>    
                </div>
                      
                        
                    </div> -->
 
                   
                    
                </div>
                
            </div>
            
        </div>
    </div>
   
    </AdminLayout>

    
</template>
