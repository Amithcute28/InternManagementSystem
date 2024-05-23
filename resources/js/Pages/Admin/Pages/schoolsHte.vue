<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ReusableCard from "@/Components/ReusableCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalDialog from "@/Components/ModalDialog.vue";
import Arrow from "@/Components/Arrow.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  schools: Array,
});

const modalActive = ref(null);
const toggleModal = () => {
  modalActive.value = !modalActive.value;
};

const form = useForm({
  schoolName: "",
  schoolAddress: "",
  schoolLogo: null,
  required_programs: "",
  skills: "",
});

const submit = () => {
  let formData = new FormData();
  formData.append("schoolName", form.schoolName);
  formData.append("schoolAddress", form.schoolAddress);
  formData.append("schoolLogo", form.schoolLogo);
  formData.append("required_programs", form.required_programs);
  formData.append("skills", form.skills);

  form.post(route("schools.store"), formData, {
    onFinish: () => form.reset("schoolName", "schoolAddress", "schoolLogo", "required_programs", "skills"),
  });

  modalActive.value = false;
};

const selectedInstitution = ref(null);

function openModal(school) {
  selectedInstitution.value = school;
  document.getElementById('myModal').showModal();
}
</script>


<template>
  <Head title="Schools" />

    <AdminLayout>

      
<div class="h-screen mt-16">
    <div class="flex justify-end">
            
            <!-- <Link :href="route('schools.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded" @click="toggleModal" @close-modal="toggleModal">Add New School</Link> -->
             <PrimaryButton class="px-3 py-2 mx-6 text-white font-semibold rounded" @click="toggleModal" >Add New HTE</PrimaryButton>
           
           </div>
        <div class="grid grid-cols-2 gap-0">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                <div class="grid grid-cols-12 gap-6 ">
                    <ReusableCard v-for="school in schools" :key="school.id">
                       
                        <img :src="school.school_logo" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">{{ school.name }}</p>
                            <p class="font-semibold text-sm text-gray-400 mb-5">{{ school.address }}</p>
                           <button @click="openModal(school)" class="px-2 py-2  text-white bg-indigo-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mr-2">More info</button>
                           <Link
                            :href="route('schools.schoolsDestroy', school.id)"
                            class="px-2 py-2  text-white bg-red-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >Delete</Link>
                            
                           
                           <!-- <PrimaryButton :href="route('students.create')" ><template #icon>  <Arrow></Arrow> </template>  Read More</PrimaryButton> -->
                        </div> 

                    </ReusableCard>
                     <ModalDialog :modalActive="modalActive" @close-modal="toggleModal">
                        

    <form
      class="py-2"
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

<div class="grid grid-cols-2 gap-5">
  <div class="col-span-1 mb-5">
    <label for="schoolName" class="mb-3 block text-base font-medium text-[#07074D]">
      Needed Program:
    </label>
    <input type="text" v-model="form.required_programs" name="required_programs" id="required_programs" placeholder="Programs" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
  <div class="col-span-1 mb-5">
    <label for="schoolName" class="mb-3 block text-base font-medium text-[#07074D]">
      Additional Skills:
    </label>
    <input type="text" v-model="form.skills" name="schoolAddress" id="skills" placeholder="Skills" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
</div>

                <div class="mb-6 pt-4">
                  <label
                    class="mb-5 block text-xl font-semibold text-[#07074D]"
                  >
                    Upload Logo
                  </label>

                  <div class="mb-8">
                    <input
                      type="file"
                      @input="form.schoolLogo = $event.target.files[0]"
                      name="schoolLogo"
                      id="schoolLogo"
                      class="sr-only"
                    />
                    <label
                      for="schoolLogo"
                      class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center"
                    >
                      <div>
                        <span
                          class="mb-2 block text-xl font-semibold text-[#07074D]"
                        >
                          Drop files here
                        </span>
                        <span
                          class="mb-2 block text-base font-medium text-[#6B7280]"
                        >
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

                  <div
                    class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8"
                    v-if="form.schoolLogo"
                  >
                    <div class="flex items-center justify-between">
                      <span
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
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
                    type="submit"
                    class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
                  >
                    Add School
                  </button>
                </div>
              </form>
            </ModalDialog>
          </div>
        </div>
      </div>
    </div>

    <dialog id="myModal" class="p-5  bg-white rounded-md ">
        
   <div class="flex flex-col w-full h-auto ">
        <!-- Header -->
        <div class="flex w-full h-auto justify-between items-center">
          <div class="flex h-auto py-3 justify-center items-center text-2xl font-bold">
                Institution Information
          </div>
          <div onclick="document.getElementById('myModal').close();" class="flex w-1/12 h-auto justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
        </div>
          <!--Header End-->
          <!-- Modal Content-->
           
<div class="container my-4 px-6 mx-auto">

<!-- Section: Design Block -->
<section class="text-gray-800">
  
  <div class="flex flex-wrap">
      <div class="grow-0 shrink-0 basis-auto block w-full lg:flex lg:w-6/12 xl:w-4/12">
        <div class="map-container-2 w-full">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1956.657715528662!2d125.00004053842936!3d11.238190528016471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3308772c87c4c367%3A0xa5e5c080ec6a88ef!2sLeyte%20Normal%20University!5e0!3m2!1sen!2sph!4v1683656352509!5m2!1sen!2sph" class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>  
      <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 xl:w-8/12">
      <div class="bg-white p-3 flex items-center justify-between ml-6 mb-4">
                  <div class="flex space-x-6 items-center" v-if="selectedInstitution">
                    
                      <img :src="selectedInstitution.school_logo" class="w-auto h-24 rounded-lg"/>
                      <div >
                          <p class="font-semibold text-2xl">{{ selectedInstitution.name }}</p>
                          <p class="font-semibold text-lg text-gray-400">{{ selectedInstitution.address }}</p>
                      </div>              
                  </div>
              </div>
        <div class="flex flex-col justify-center items-center" v-if="selectedInstitution">
            <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Address</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ selectedInstitution.address }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Requirements</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ selectedInstitution.requirements }}
                    </p>
                    </div>

                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Programs</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ selectedInstitution.required_programs }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Skills</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ selectedInstitution.skills }}
                    </p>
                    </div>

                  
                </div>
            </div>  
           
        </div>
        
      </div>
        
    </div>
  
</section>

</div>

        </div>
</dialog>
  </AdminLayout>
</template>

<style>
.map-container-2 {
        height: 500px;
}

   dialog[open] {
  animation: appear .15s cubic-bezier(0, 1.8, 1, 1.8);
}

  dialog::backdrop {
    background: linear-gradient(45deg, rgba(0, 0, 0, 0.5), rgba(54, 54, 54, 0.5));
    backdrop-filter: blur(3px);
  }
  
 
@keyframes appear {
  from {
    opacity: 0;
    transform: translateX(-3rem);
  }

  to {
    opacity: 1;
    transform: translateX(0);
  }
} 
</style>