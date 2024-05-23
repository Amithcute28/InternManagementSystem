<script setup>
 import AdminLayout from '@/Layouts/AdminLayout.vue';
 import ReusableCard from "@/Components/ReusableCard.vue";
  import { Head } from '@inertiajs/vue3';
   import { Link } from '@inertiajs/vue3';
  import { defineProps, ref } from 'vue';
  import { useForm } from "@inertiajs/vue3";
  

  const props = defineProps({
    student: {
      type: Object,
      required: true,
    },
  });
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
  guardian_contact: props.student?.guardian_contact,
  recommend: props.student?.recommend,
});



const submit = () => {
  console.log( props.student?.id);
  form.put(route("recommender.update", props.student?.id));
};

const selectedInstitution = ref(null);

function openModal(institution) {
  selectedInstitution.value = institution;
  document.getElementById('myModal').showModal();
}



</script>

<template>
<AdminLayout>

  <div class="py-12">
    <div>
    <Link :href="route('recommender.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Back</Link>
    </div>
    <Head>
      <title>Recommended Institutions for {{ student.full_name }}</title>
    </Head>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h1 class="text-2xl font-bold mb-4">Recommended Institutions for {{ student.full_name }}</h1>
          <div class="mb-4">
            <p><strong>Program:</strong> {{ student.program }}</p>
            <p><strong>Email:</strong> {{ student.email }}</p>
            <p><strong>Academic Performance:</strong> {{ student.academic_performance }}</p>
            <p><strong>Skills:</strong> {{ student.skills }}</p>
          </div>
         
        </div>
      </div>
    </div>
  </div>

   <div class="grid grid-cols-2 gap-0">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                <div class="grid grid-cols-12 gap-6 ">
                    <ReusableCard v-for="institution in student.recommended_institutions" :key="institution.name">
                       
                        <img :src="institution.school_logo" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">{{ institution.name }}</p>
                            <p class="font-semibold text-sm text-gray-400">{{ institution.address }}</p>
                            <p class="font-semibold text-sm text-gray-400">Required programs: {{ institution.required_programs }}</p>
                            <p class="font-semibold text-sm text-gray-400 mb-6">Required Skills: {{ institution.skills }}</p>
                            
                            <button @click="openModal(institution)" class="px-2 py-2  text-white bg-indigo-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">More info</button>

                        </div> 

                    </ReusableCard>
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

           
<div class="container my-4 px-6 mx-auto">


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

<Link :href="route('recommender.update', student.id)" method="PUT" as="button" class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">Recommend na</Link>
  
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