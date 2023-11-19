  <script setup>
  import AdminLayout from "@/Layouts/AdminLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import { Link, useForm } from "@inertiajs/vue3";
  import Table from "@/Components/Table.vue";
  import TableRow from "@/Components/TableRow.vue";
  import TableHeaderCell from "@/Components/TableHeaderCell.vue";
  import TableDataCell from "@/Components/TableDataCell.vue";
  import ReusableCard2 from "@/Components/ReusableCard2.vue";

  const props = defineProps({
  students: Array,
});
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
        form.post(route('coordinators.store'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
  </script>

  <template>
    <Head title="Coordinators" />

    <AdminLayout>
      <div class="mt-16">
         <div class="flex justify-between">
        <p class="text-2xl font-semibold ml-4">Coordinators</p>
          <button onclick="document.getElementById('myModal').showModal()" id="btn" class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">New Intern</button>
        <!-- <Link
          :href="route('students.create')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          >New Students</Link
        > -->
        
      </div>
        
      </div>



 <div class="grid grid-cols-2 gap-0">
            <div class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6">
                <div class="grid grid-cols-12 gap-6">
                    <ReusableCard2 v-for="admin in students" :key="admin.id">
                       
                        <img :src="admin.school_logo" class="w-auto h-24 rounded-lg"/>
                        <div>
                          <h3 class="mb-1 text-2xl font-bold leading-normal text-gray-700 dark:text-gray-300">
                        {{ admin.full_name }}
                      </h3>
                      <div
                        class="flex flex-row justify-center w-full mx-auto space-x-2 text-center"
                      >
                        <!-- /typography/_h3.antlers.html -->
                        <div
                          class="text-sm font-bold tracking-wide text-gray-600 dark:text-gray-300 font-mono text-xl mb-5"
                        >
                          {{ admin.email }}
                        </div>
                        <!-- End: /typography/_h3.antlers.html -->
                      </div>
                           
                            <Link
                            :href="route('coordinators.destroy', admin.id)"
                            method="DELETE"
                            class="px-2 py-2  text-white bg-red-500 hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >Delete</Link>
                           
                           <!-- <PrimaryButton :href="route('students.create')" ><template #icon>  <Arrow></Arrow> </template>  Read More</PrimaryButton> -->
                        </div> 

                    </ReusableCard2>
                     
          </div>
        </div>
      </div>


      <dialog id="myModal" class="h-auto w-11/12 md:w-1/2 p-5  bg-white rounded-md ">
        
   <div class="flex flex-col w-full h-auto ">
        <!-- Header -->
        <div class="flex w-full h-auto justify-between items-center">
          <p class="mt-2 text-lg">New Intern</p>
          <div onclick="document.getElementById('myModal').close();" class="flex w-1/12 h-auto justify-center cursor-pointer mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
          </div>
          <!--Header End-->
        </div>
          <!-- Modal Content-->
           <div class="bg-white pb-10 px-10 rounded-xl shadow-xl mt-16">
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
