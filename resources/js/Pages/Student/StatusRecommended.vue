<script setup>
 import UserLayout from '@/Layouts/UserLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link} from "@inertiajs/vue3";
    import { defineProps, ref } from 'vue';

    const props = defineProps({
    institution: {
        type: Object,
        required: true
    },
    student: {
        type: Object,
        required: true
    },
    
})
    
</script>

<template>
    <Head title="Status" />

    <UserLayout>
          <div class="container mx-auto bg-white mt-16">
        <div class="md:flex no-wrap md:-mx-2 ">
            <!-- Left Side -->
            
            <!-- Right Side -->
            <div class="w-full mx-2 h-64">
                <!-- Profile tab -->
                <!-- About Section -->
                <div class="bg-white p-3 rounded-xl shadow-md">
                   
                   
                   
                  
    <div>
   
    </div>
    <Head>
      <title>Recommended Institutions for {{ student.full_name }}</title>
    </Head>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h1 class="text-2xl font-bold mb-4">Recommended Institutions for {{ student.full_name }}</h1>
          
          <div class="mb-4 grid md:grid-cols-2">
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

          <section class="text-gray-800">
  
  <div class="block rounded-lg shadow-lg bg-white">
    <div class="flex flex-wrap">
      <div class="grow-0 shrink-0 basis-auto block w-full lg:flex lg:w-6/12 xl:w-4/12">
        <div class="map-container-2 w-full">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1956.657715528662!2d125.00004053842936!3d11.238190528016471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3308772c87c4c367%3A0xa5e5c080ec6a88ef!2sLeyte%20Normal%20University!5e0!3m2!1sen!2sph!4v1683656352509!5m2!1sen!2sph" class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>  
      <div class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 xl:w-8/12">
      <div class="bg-white p-3 flex items-center justify-between ml-6 mt-4 mb-4">
                  <div class="flex space-x-6 items-center">
                      <img :src="institution.school_logo" class="w-auto h-24 rounded-lg"/>
                      <div>
                          <p class="font-semibold text-2xl">{{ student.program === 'BSED' ? institution.namebsed : institution.name }}</p>
                          <p class="font-semibold text-lg text-gray-400">{{ institution.address }}</p>
                      </div>              
                  </div>
              </div>
        <div class="flex flex-col justify-center items-center">
            <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Address</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ institution.address }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Requirements</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ institution.requirements }}
                    </p>
                    </div>

                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Programs</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ institution.required_programs }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Skills</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ institution.skills }}
                    </p>
                    </div>

                  
                </div>
            </div>  
           
        </div>
        
      </div>
        
    </div>
  </div>
</section>
        </div>
      </div>
    </div>
  </div>
                         
                         
                </div>
                <!-- End of about section -->

                

               
            </div>
        </div>
    
      


    </UserLayout>
</template>

<style>
.map-container-2 {
        height: 500px;
}
</style>