<script setup>
 import UserLayout from '@/Layouts/UserLayout.vue';
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
// const form = useForm({
//   student_id: props.student?.student_id,
//   program: props.student?.program,
//   year_level: props.student?.year_level,
//   full_name: props.student?.full_name,
//   email: props.student?.email,
//   birthday: props.student?.birthday,
//   gender: props.student?.gender,
//   relationship: props.student?.relationship,
//   nationality: props.student?.nationality,
//   contact_number: props.student?.contact_number,
//   home_address: props.student?.home_address,
//   zip_code: props.student?.zip_code,
//   guardian_name: props.student?.guardian_name,
//   guardian_contact: props.student?.guardian_contact,
//   recommend: props.student?.recommend,
// });


// const submit = () => {
//   console.log( props.student?.id);
//   form.put(route("recommender.update", props.student?.id));
// };

const selectedInstitution = ref(null);

function openModal(institution) {
  selectedInstitution.value = institution;
  document.getElementById('myModal').showModal();
}



</script>

<template>
<UserLayout>

  <div class="py-12">
    <div>
   
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
          <!-- <ul>
            <li v-for="institution in student.recommended_institutions" :key="institution.name" class="my-2">
              <div class="font-bold">{{ institution.name }}</div>
              <div class="text-gray-500">{{ institution.required_programs }}</div>
              <div class="text-gray-500">{{ institution.skills}}</div>
              <div class="text-gray-500">{{ institution.address }}</div>
              <div class="text-sm text-gray-500">Required Academic Performance: {{ institution.academic_performance }}</div>
              
            </li>
          </ul> -->
        </div>
      </div>
    </div>
  </div>

   <div class="grid grid-cols-2 gap-0">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                <div class="grid grid-cols-12 gap-6 ">
                    <ReusableCard v-for="institution in student.recommended_institutions" :key="institution.name" :student="student">
                       
                        <img :src="institution.school_logo" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">{{ institution.name }}</p>
                            <p class="font-semibold text-sm text-gray-400">{{ institution.address }}</p>
                            <p class="font-semibold text-sm text-gray-400">{{ institution.required_programs }}</p>
                            <p class="font-semibold text-sm text-gray-400">{{ institution.skills }}</p>
                            <p class="font-semibold text-sm text-gray-400 mb-5">Required Academic Performance: {{ institution.academic_performance }}</p>
                           <Link :href="route('status.update', {studentId: student.id, institutionId: institution.id})" method="PUT" as="button" class="px-2 py-2  text-white bg-indigo-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Choose</Link>
                            <button @click="openModal(institution)" class="px-2 py-2  text-white bg-indigo-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 ml-6">More info</button>
                            
                           <!-- <PrimaryButton :href="route('students.create')" ><template #icon>  <Arrow></Arrow> </template>  Read More</PrimaryButton> -->
                        </div> 

                    </ReusableCard>
                    
                        </div>
                        </div>
                        </div>
  

        <!-- Header -->
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
<section class=" text-gray-800">
  
  
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
                      <div>
                          <p class="font-semibold text-2xl">{{ selectedInstitution.name }}</p>
                          <p class="font-semibold text-lg text-gray-400">{{ selectedInstitution.address }}</p>
                      </div>              
                  </div>
              </div>
        <div class="flex flex-wrap pt-12 lg:pt-0">
          <div class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12">
            <div class="flex items-start">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="headset" class="w-5 text-white"
                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                      d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z">
                    </path>
                  </svg>
                </div>
              </div>
              
              <div class="grow ml-6">
                <p class="font-bold mb-1">Requirements</p>
                <p class="text-gray-500"></p>
                <p class="text-gray-500">+1 234-567-89</p>
              </div>
            </div>
          </div>
          <div class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12">
            <div class="flex items-start">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="dollar-sign"
                    class="w-3 text-white" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 288 512">
                    <path fill="currentColor"
                      d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-6" >
                <p class="font-bold mb-1">School Info</p>
                <p class="text-gray-500">sales@example.com</p>
                <p class="text-gray-500">+1 234-567-89</p>
              </div>
            </div>
          </div>
          <div class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12">
            <div class="flex align-start">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="newspaper"
                    class="w-5 text-white" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path fill="currentColor"
                      d="M552 64H88c-13.255 0-24 10.745-24 24v8H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h472c26.51 0 48-21.49 48-48V88c0-13.255-10.745-24-24-24zM56 400a8 8 0 0 1-8-8V144h16v248a8 8 0 0 1-8 8zm236-16H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm-208-96H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm0-96H140c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h360c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-6">
                <p class="font-bold mb-1">School Info</p>
                <p class="text-gray-500">press@example.com</p>
                <p class="text-gray-500">+1 234-567-89</p>
              </div>
            </div>
          </div>
          <div class="mb-12 lg:mb-0 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12">
            <div class="flex align-start">
              <div class="shrink-0">
                <div class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bug" class="w-5 text-white"
                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                      d="M511.988 288.9c-.478 17.43-15.217 31.1-32.653 31.1H424v16c0 21.864-4.882 42.584-13.6 61.145l60.228 60.228c12.496 12.497 12.496 32.758 0 45.255-12.498 12.497-32.759 12.496-45.256 0l-54.736-54.736C345.886 467.965 314.351 480 280 480V236c0-6.627-5.373-12-12-12h-24c-6.627 0-12 5.373-12 12v244c-34.351 0-65.886-12.035-90.636-32.108l-54.736 54.736c-12.498 12.497-32.759 12.496-45.256 0-12.496-12.497-12.496-32.758 0-45.255l60.228-60.228C92.882 378.584 88 357.864 88 336v-16H32.666C15.23 320 .491 306.33.013 288.9-.484 270.816 14.028 256 32 256h56v-58.745l-46.628-46.628c-12.496-12.497-12.496-32.758 0-45.255 12.498-12.497 32.758-12.497 45.256 0L141.255 160h229.489l54.627-54.627c12.498-12.497 32.758-12.497 45.256 0 12.496 12.497 12.496 32.758 0 45.255L424 197.255V256h56c17.972 0 32.484 14.816 31.988 32.9zM257 0c-61.856 0-112 50.144-112 112h224C369 50.144 318.856 0 257 0z">
                    </path>
                  </svg>
                </div>
              </div>
              <div class="grow ml-6">
                <p class="font-bold mb-1">School Info</p>
                <p class="text-gray-500">bugs@example.com</p>
                <p class="text-gray-500">+1 234-567-89</p>
              </div>
            </div>
          </div>
          
          
        </div>
        
      </div>
        
    </div>

</section>
<!-- Section: Design Block -->

</div>
          <!-- End of Modal Content-->
          
          
          
        </div>
</dialog>


  

  </UserLayout>
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