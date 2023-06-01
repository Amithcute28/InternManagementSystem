<script setup>
 import AdminLayout from '@/Layouts/AdminLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { Link} from "@inertiajs/vue3";
    import { defineProps } from 'vue';
    import { ref } from 'vue';
    import Table from '@/Components/Table.vue';
    import TableRow from '@/Components/TableRow.vue';
    import TableHeaderCell from '@/Components/TableHeaderCell.vue';
    import TableDataCell from '@/Components/TableDataCell.vue';


    const props = defineProps({
        students: {
            type: Array,
            required: true,
        },
        institution: {
        type: Object,
        required: true
    },
    });

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

    const applications = ref(null);

function openModal(student) {
  applications.value = student;
  document.getElementById('myModal').showModal();
}

 const recommend = ref(null);

function openModalRecommend(student) {
  recommend.value = student;
  document.getElementById('myModalRecommend').showModal();
}


</script>

<template>
    <Head title="Off Campus" />

    <AdminLayout>
        <!-- <div class="mt-16 flex">

            <div class="w-full">
                <h1 class="text-xl font-bold mb-4">Students</h1>
                <div class="bg-white shadow-md rounded my-6">
                    <table class="w-full table-auto"> 
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Program</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Academic Performance</th>
                                <th class="py-3 px-4 text-left"></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="student in students" :key="student.id" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-4">{{ student.full_name }}</td>
                                <td class="py-3 px-4">{{ student.program }}</td>
                                <td class="py-3 px-4">{{ student.email }}</td>
                                <td class="py-3 px-4">{{ student.academic_performance }}</td>
                                <td class="py-3 px-4">
                                    <Link :href="route('offcampus.show', { id: student.id })" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</Link>
                                    <ul v-if="student.recommended_institutions.length > 0">
                                        <li v-for="institution in student.recommended_institutions" :key="institution.id">
                                            {{ institution.name }} - {{ institution.required_academic_performance }}
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->

        <div class="mt-16">
            <div class="flex justify-between">
            <h1>List of students</h1>
           </div>
            <div class="mt-6">
            <Table>
                    <template #header>
                    <TableRow>
                    <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                    </div>
                    </th>
                        <TableHeaderCell>Student ID</TableHeaderCell>
                        <TableHeaderCell>Name</TableHeaderCell>
                        <TableHeaderCell>Program</TableHeaderCell>
                        <TableHeaderCell>In-Campus</TableHeaderCell>
                        <TableHeaderCell>Evaluation Form</TableHeaderCell>
                        <TableHeaderCell>Status</TableHeaderCell>
                        <TableHeaderCell>Action</TableHeaderCell>
                    </TableRow>
                    </template>

                    <template #default>
                        
                       <TableRow class="overflow-auto" v-for="student in students" :key="student.id">
                            <td class="w-4 p-4 bg-white">
                            <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                            </td>

                            <TableDataCell>{{ student.student_id }}</TableDataCell>
                            <TableDataCell class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" :src="`storage/${student.profile}`" alt="Jese image">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ student.full_name }}</div>
                                    <div class="font-normal text-gray-500">{{ student.email }}</div>
                                     </div>  
                            </TableDataCell>
                             <TableDataCell>{{ student.program }}</TableDataCell>
                              <TableDataCell> <button @click="openModal(student)" class="px-6 py-2  text-white bg-gold hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button></TableDataCell>
                               <TableDataCell
              ><a
                v-if="isImage(student.eval_form)"
                :href="student.psa"
                target="_blank"
              >
                <img
                  :src="student.eval_form"
                  style="max-width: 100%; max-height: 100px"
                  class="h-16 w-16"
                />
              </a>
              <a
                v-else-if="isPdf(student.eval_form)"
                :href="studenteval_form"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(student.eval_form)"
                :href="student.eval_form"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="student.eval_form"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell>
                            <TableDataCell>
                             <!-- <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Deployed
                             </div> -->
                            </TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('offcampus.show', student.id)"  class="text-green-400 hover:text-green-600">View</Link>
                               <button @click="openModalRecommend(student)" class="px-6 py-2  text-white bg-gold hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
        </div>
        </div>

        <dialog id="myModal" class="p-5  bg-darkWhite rounded-md ">
      <div class="flex w-full h-auto justify-between items-center">
          <div class="flex h-auto py-3 justify-center items-center text-2xl font-bold">
                In-Campus Application
          </div>
          <div onclick="document.getElementById('myModal').close();" class="flex w-1/12 h-auto justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
        </div>
        <div class="flex items-center flex-col p-10">
        <!-- main card -->
      
            <!-- headers content-->
           
            <!-- subscriptions -->
            <div class="grid grid-cols-12 gap-6" v-if="applications">
  <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">          
  <div class="h-44 p-5">
  <label
    for="country"
    class=" text-lg leading-6 text-black mb-12 flex items-center "
    >Entrance Slip</label
  >
  <a v-if="isImage(applications.eslip)" :href="applications.eslip" target="_blank">
  <img
    :src="applications.eslip"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.eslip)"
  :href="applications.eslip"
  target="_blank"
  class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.eslip)"
  :href="applications.eslip"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.eslip"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>

             <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">        
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-12"
    >PSA Livebirth</label
  >
  <a v-if="isImage(applications.psa)" :href="applications.psa" target="_blank">
  <img
    :src="applications.psa"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.psa)"
  :href="applications.psa"
  target="_blank"
  class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.psa)"
  :href="applications.psa"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.psa"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>
       

        
           <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">        
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-12"
    >Prospectus</label
  >
  <a v-if="isImage(applications.pros)" :href="applications.pros" target="_blank">
  <img
    :src="applications.pros"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.pros)"
  :href="applications.pros"
  target="_blank"
   class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.pros)"
  :href="applications.pros"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.pros"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>
       


           <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">        
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-12"
    >Application Form</label
  >
   <a
  v-if="isImage(applications.applicationF)"
  :href="applications.applicationF"
  target="_blank"
>
  <img
    :src="applications.applicationF"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.applicationF)"
  :href="applications.pros"
  target="_blank"
   class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.applicationF)"
  :href="applications.applicationF"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.applicationF"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>

            <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">         
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-12"
    >Medical Certificate</label
  >
  <a
  v-if="isImage(applications.medical)"
  :href="applications.medical"
  target="_blank"
>
  <img
    :src="applications.medical"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.medical)"
  :href="applications.medical"
  target="_blank"
   class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.medical)"
  :href="applications.medical"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.medical"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>

            <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">        
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-12"
    >Parent's Permit</label
  >
  <a
  v-if="isImage(applications.parent)"
  :href="applications.parent"
  target="_blank"
>
  <img
    :src="applications.parent"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.parent)"
  :href="applications.parent"
  target="_blank"
   class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.parent)"
  :href="applications.paremt"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.parent"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>

            <div class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white">      
  <div class="h-44 p-5">
  <label
    for="country"
    class="block text-lg leading-6 text-black mb-2"
    >2x2 ID</label
  >
 <a
  v-if="isImage(applications.twobytwo)"
  :href="applications.twobytwo"
  target="_blank"
  class=""
>
  <img
    :src="applications.twobytwo"
    style="max-width: 100%; max-height: 100px"
  />
</a>
<a
  v-else-if="isPdf(applications.twobytwo)"
  :href="applications.twobytwo"
  target="_blank"
   class="bg-yellow-200 text-yellow-600 py-10 ml-4 px-12 rounded-lg text-xs"
  >PDF</a
>
<a
  v-else-if="isDoc(applications.twobytwo)"
  :href="applications.twobytwo"
  target="_blank"
  class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
  >DOC FILE</a
>
<a
  v-else
  :href="applications.twobytwo"
  target="_blank"
  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
  >MISSING</a
>
</div>

                <!-- <button class="bg-gold px-2 py-2 rounded-lg mt-4">
                    Add subscription
                </button> -->
            </div>

           
        </div>
           

            <div class="flex justify-center">
                <button class="mt-12 bg-gold text-white rounded-lg py-2"></button>
            </div>
        </div>
  
   
</dialog>

 <dialog id="myModalRecommend" class="p-5  bg-darkWhite rounded-md ">
      <div class="flex w-full h-auto justify-between items-center">
          <div class="flex h-auto py-3 justify-center items-center text-2xl font-bold">
                In-Campus Application
          </div>
          <div onclick="document.getElementById('myModalRecommend').close();" class="flex w-1/12 h-auto justify-center cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
        </div>
        <div class="flex items-center flex-col p-10">
        <!-- main card -->
      
            <!-- headers content-->
           
            <!-- subscriptions -->
            <div class="container mx-auto bg-white mt-16" v-if="recommend">
          
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
      <title>Recommended Institutions for {{ recommend.full_name }}</title>
    </Head>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <h1 class="text-2xl font-bold mb-4">{{ recommend.full_name }}</h1>
          
          <div class="mb-4 grid md:grid-cols-2">
            <p><strong>Program:</strong> {{ recommend.program }}</p>
            <p><strong>Email:</strong> {{ recommend.email }}</p>
            <p><strong>Academic Performance:</strong> {{ recommend.academic_performance }}</p>
            <p><strong>Skills:</strong> {{ recommend.skills }}</p>
          </div>
          
           <h1 class="text-2xl font-bold mb-4">Recommended Institution:</h1>
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
                      <img :src="recommend.school_logo" class="w-auto h-24 rounded-lg"/>
                      <div>
                          <p class="font-semibold text-2xl">{{ recommend.name }}</p>
                          <p class="font-semibold text-lg text-gray-400">{{ recommend.address }}</p>
                      </div>              
                  </div>
              </div>
        <div class="flex flex-col justify-center items-center">
            <div class="relative flex flex-col items-center rounded-[20px] w-[700px] max-w-[95%] mx-auto bg-white bg-clip-border shadow-3xl shadow-shadow-500 dark:!bg-navy-800 dark:text-white dark:!shadow-none p-3">
                <div class="grid grid-cols-2 gap-4 px-2 w-full">
                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Address</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ recommend.address }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Requirements</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ recommend.requirements }}
                    </p>
                    </div>

                    <div class="flex flex-col items-start justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Programs</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ recommend.required_programs }}
                    </p>
                    </div>

                    <div class="flex flex-col justify-center rounded-2xl bg-white bg-clip-border px-3 py-4 shadow-3xl shadow-shadow-500 dark:!bg-navy-700 dark:shadow-none">
                    <p class="text-lg text-gray-600">Required Skills</p>
                    <p class="text-base font-medium text-navy-700 dark:text-white">
                        {{ recommend.skills }}
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

            <div class="flex justify-center">
                <button class="mt-12 bg-gold text-white rounded-lg py-2"></button>
            </div>
        </div>
  
   
</dialog>


    </AdminLayout>
</template>

<style>
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