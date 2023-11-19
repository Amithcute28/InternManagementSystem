<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import ReusableCard from "@/Components/ReusableCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalDialog from "@/Components/ModalDialog.vue";
import Arrow from "@/Components/Arrow.vue";
import { Head } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

defineProps(["users"]);

const modalActive = ref(null);
const toggleModal = () => {
  modalActive.value = !modalActive.value;
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
        <div class="mt-16">
         <div class="flex justify-between">
        <p class="text-2xl font-semibold ml-4">Coordinator Profile</p>
         
          <Link v-for="admin in users" :key="admin.id" :href="route('adminProfile.edit', admin.id)" class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit Information</Link>
        <!-- <Link
          :href="route('students.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        > -->
        
      </div>
      <div class="bg-gray-100 mt-16">
 <div class="w-full text-white bg-main-color">
        <div x-data="{ open: false }"
            class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
           
           
        </div>
    </div>
    <!-- End of Navbar -->
    

    <div class="container mx-auto bg-white">
        <div class="md:flex no-wrap md:-mx-2 ">
            <!-- Left Side -->
            
            <!-- Right Side -->
            <div class="w-full mx-2 h-64">
                <!-- Profile tab -->
                <!-- About Section -->
                <div class="bg-white p-3 rounded-xl shadow-md">
                    


                    <div class="flex items-center  space-x-2 ml-3 font-semibold text-gray-900 leading-8">
                        <span clas="text-green-500">
                            <svg class="h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <span class="tracking-wide">About</span>
                    </div>
                    <div class=" text-gray-700" >
                      
                        <div class="grid md:grid-cols-2 text-sm">

                        
                             

                              
                            <div class="grid grid-cols-2 ">
                                
                                <div class="px-4 py-2 font-semibold">Full name</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.full_name }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold"> Student ID</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.student_id }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Program</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.program }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Email</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.email }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Contact Number</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.contact_number }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Birthday</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.birthday }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Gender</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.gender }}</div>
                            </div>
                              <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Relationship</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.relationship }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Nationality</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.nationality }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Home Address</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.home_address }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Guardian Name</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.guardian_name }}</div>
                            </div>
                            <div class="grid grid-cols-2">
                                <div class="px-4 py-2 font-semibold">Guardian Contact Number</div>
                                <div class="px-4 py-2">{{ $page.props.auth.user.guardian_contact }}</div>
                            </div>
                              
                           
                        </div>
                    </div>
                   
                   
                         
                         
                </div>
                <!-- End of about section -->

                <div class="my-4"></div>

                <!-- Experience and education -->
               
                <!-- End of profile tab -->
            </div>
        </div>
    </div>
</div>
      
        
      </div>
        
      

   
  </AdminLayout>
</template>

<style>
.map-container-2 {
        height: 500px;
}
 .modal-dialog-open {
    animation: appear .15s cubic-bezier(0, 1.8, 1, 1.8);
  }

  .modal-dialog-backdrop {
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