<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";
import { initFlowbite } from 'flowbite'
import { onMounted } from "vue";
import { ref, watch} from "vue";
import { router } from '@inertiajs/vue3'


const props = defineProps({
        approved: Array,
        interns: Array,
        files: Array,
        filters: Array,

    });
// initialize components based on data attribute selectors
const search = ref(props.filters.search);
const perPage = ref(5);

watch(search, (value) => {
  router.get('students', { search: value }, {
    preserveState: true,
    replace: true
  });
});

function getTags() {
  router.get('students', { perPage: perPage.value }, {
    preserveState: true,
    replace: true,
  })
}

onMounted(() => {
    initFlowbite();
})


const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const offCampus = (form) => {
  return (
    form.eslip &&
    form.psa &&
    form.pros &&
    form.applicationF &&
    form.medical &&
    form.parent &&
    form.twobytwo && 
    form.eval_form && 
    form.is_off_campus === 1
  );
};

const inCampus = (form) => {
  return (
    form.eslip &&
    form.psa &&
    form.pros &&
    form.applicationF &&
    form.medical &&
    form.parent &&
    form.twobytwo && 
    form.eval_form && 
    form.in_campus === 0

  );
};
const totalInterns = props.interns.length;
const form = useForm({
  student_id: "",
  program: "",
  full_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  full_name: "",
  email: "",

  terms: false,
});



const submit = () => {
        form.post(route('students.store'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
  <Head title="Interns" />

  <AdminLayout>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <p class="text-2xl font-semibold ml-4">Interns</p>
          <button onclick="document.getElementById('myModal').showModal()" id="btn" class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">New Intern</button>
      </div>
<div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
              
              <div class="flex items-center flex-1 space-x-4">
                  <h5>
                      <span class="text-gray-500">All Interns: </span>
                      <span class="dark:text-white">{{ totalInterns }}</span>
                  </h5>
        
              </div>
              <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                
      <label for="table-search" class="sr-only">Search</label>
      <div class="relative">
          <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
              <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
          </div>
           <input
              v-model="search"
                type="text"
                id="table-search-users"
                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-72 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search for interns"
              />
      </div>
            <div>
              <select
                v-model="perPage"
                @change="getTags"
                class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:ring-0 text-sm">
                <option value="5">5 Per Page</option> 
                <option value="10">10 Per Page</option> 
                <option value="15">15 Per Page</option> 


              </select>
</div>

              </div>
          </div>
    </div>
   
      <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell>Student ID</TableHeaderCell>
            <TableHeaderCell >Name</TableHeaderCell>
            <TableHeaderCell >Program</TableHeaderCell>
            <TableHeaderCell >School</TableHeaderCell>
            <TableHeaderCell >Status</TableHeaderCell>
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="form in approved.data" :key="form.id">
             <TableDataCell>{{ form.student_id }}</TableDataCell>
                            <TableDataCell class="flex items-center px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-8 h-8 rounded-full"  :src="`storage/${form.profile}`" alt="">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ form.full_name}}</div>
                                    <div class="font-normal text-gray-500">{{ form.email}}</div>
                                     </div>  
                            </TableDataCell>
            <TableDataCell>{{ form.program }}</TableDataCell>
            <TableDataCell>{{ form.student_school_name }}</TableDataCell>
             <TableDataCell>
              <template v-if="offCampus(form)">
                 <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-violet-500 mr-2"></div> 2nd Shift
                  </div>
              </template>

              <template v-else-if="inCampus(form)">
              <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-yellow-500 mr-2"></div> First Shift
                  </div>
              </template>
              
              <template v-else>
                <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-blue-500 mr-2"></div> First Shift
                  </div>
              </template></TableDataCell>

            <TableDataCell class="space-x-4">
                <Link
                  :href="route('students.edit', form.id)"
                  class="text-green-400 hover:text-green-600"
                  >Edit</Link
                >
                <Link
                  :href="route('students.destroy', form.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >
              </TableDataCell>

          </TableRow>
        </template>
      </Table>
    
    <div class="m-2 p-2">
          <Pagination :links="approved.links"/>
        </div>

    <dialog id="myModal" class="h-auto w-11/12 md:w-1/2 p-5  bg-white rounded-md ">
        
   <div class="flex flex-col w-full h-auto ">
        <!-- Header -->
        <div class="flex w-full h-auto justify-between items-center">
          <p class="mt-2 text-lg">New Intern</p>
          <div onclick="document.getElementById('myModal').close();" class="flex w-1/12 h-auto justify-center cursor-pointer mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
 
        </div>

           <div class="bg-white pb-10 px-10 mt-16">
      <div
        class="flex items-center justify-between space-x-2 ml-3 font-semibold text-gray-900 leading-8"
      >
      </div>
       
      <div class="">
        <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="student_id"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
                placeholder=" "
                v-model="form.student_id"
                required
                autocomplete="student_id"
              />
              <label
                for="student_id"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Student ID
              </label>
              <InputError class="mt-2" :message="form.errors.student_id" />
            </div>
            <div class="relative z-0 w-full mb-6 group">
              <select
                id="province"
                v-model="form.program"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option value="" disabled hidden>Program</option>
                <option>BEED</option>
                <option>BECEd</option>
                <option>BSNEd</option>
                <option>BPEd</option>
                <option>BSED English</option>
                <option>BSED Filipino</option>
                <option>BSED Mathematics</option>
                <option>BSED Science</option>
                <option>BSED Social Studies</option>
              </select>
              <InputError class="mt-2" :message="form.errors.program" />
            </div>
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="text"
              id="full_name"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.full_name"
              required
              autocomplete="full_name"
            />
            <label
              for="full_name"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Full Name</label
            >
            <InputError class="mt-2" :message="form.errors.full_name" />
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="email"
              id="email"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.email"
              required
              autocomplete="email"
            />
            <label
              for="email"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Email Address</label
            >
            <InputError class="mt-2" :message="form.errors.email" />
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="password"
              id="password"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-blue bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.password"
              required
              autocomplete="password"
            />
            <label
              for="password"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Password</label
            >
            
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="password"
              id="password_confirmation"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.password_confirmation"
              required
              autocomplete="password_confirmation"
            />
            <label
              for="password_confirmation"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Confirm Password</label
            >
            
          </div>

          <div class="flex justify-center">
            <button
              type="submit"
              class="w-80 py-2.5 block bg-gold hover:bg-gold/80 focus:bg-gold/90 text-white font-semibold rounded-lg px-4 py-3 mt-3"
            >
              Register
            </button>
          </div>
         
        </form>
      </div>
      </div>
           
        
          <!-- End of Modal Content-->
          
          
          
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