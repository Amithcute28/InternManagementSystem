    <script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Link, router } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import Swal from "sweetalert2";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const props = defineProps({
  files: {
    type: Array,
    required: true,
  },
  approved: {
    type: Array,
    required: true,
  },
});

const isComplete = (form) => {
  return (
    form.eslip &&
    form.psa &&
    form.pros &&
    form.applicationF &&
    form.medical &&
    form.parent &&
    form.twobytwo
  );
};



const updateStatus = (form) => {
  console.log(form.id);
  router.put(route("applications.updateStatus", { id: form.id }));

  Swal.fire(
    "Success!",
    "The Intern is Now Ready for Recommendation!",
    "success"
  );
};

const form = useForm({
  eslip: "",
  psa: "",
  pros: "",
  applicationF: "",
  medical: "",
  parent: "",
  twobytwo: "",
  preserveState: true,
});

const applications = ref(null);

function openModal(form) {
  applications.value = form;
  document.getElementById('myModal').showModal();
}
</script>

    <template>
  <Head title="Students" />

  <AdminLayout>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <h1>In-Campus List</h1>
      </div>
    </div>
    <div class="mt-6">
      <Table>
        <template #header>
          <TableRow>
            <TableHeaderCell class="whitespace-nowrap"
              >Student ID</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap">Name</TableHeaderCell>
            <TableHeaderCell class="whitespace-nowrap">Program</TableHeaderCell>
            <TableHeaderCell class="whitespace-nowrap"
              >Application</TableHeaderCell
            >
            <!-- <TableHeaderCell class="whitespace-nowrap"
              >PSA LiveBirth</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Prospectus</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Application Form</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Medical Certificate</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap"
              >Parent's Permit</TableHeaderCell
            >
            <TableHeaderCell class="whitespace-nowrap">2x2 ID</TableHeaderCell>
            <TableHeaderCell>First Shift</TableHeaderCell> -->
            <TableHeaderCell>Status</TableHeaderCell>
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700" v-for="form in approved" :key="form.id">
            <TableDataCell>{{ form.student_id }}</TableDataCell>
             <TableDataCell class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-8 h-8 rounded-full" :src="`storage/${form.profile}`" alt="">
                                    <div class="pl-3">
                                    <div class="text-base font-semibold">{{ form.full_name }}</div>
                                    <div class="font-normal text-gray-500">{{ form.email }}</div>
                                     </div>  
                            </TableDataCell>
            <TableDataCell>{{ form.program }}</TableDataCell>
            
          <TableDataCell> <button @click="openModal(form)" class="px-6 py-2  text-white bg-gold hover:bg-indigo-400 rounded-lg  focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</button></TableDataCell>
           <TableDataCell>
              <template v-if="isComplete(form)">
             <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Completed
                  </div>
              </template>
              <template v-else>
                <div class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div> Incomplete
                  </div>
              </template></TableDataCell>
            <!-- <TableDataCell
              ><a v-if="isImage(form.eslip)" :href="form.psa" target="_blank">
                <img
                  :src="form.eslip"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.eslip)"
                :href="form.eslip"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.eslip)"
                :href="form.eslip"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.eslip"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            > -->



            <!-- <TableDataCell>
              <a v-if="isImage(form.psa)" :href="form.psa" target="_blank">
                <img
                  :src="form.psa"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.psa)"
                :href="form.psa"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.psa)"
                :href="form.psa"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.psa"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              >
            </TableDataCell>

            <TableDataCell>
              <a v-if="isImage(form.pros)" :href="form.pros" target="_blank">
                <img
                  :src="form.pros"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.pros)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.pros)"
                :href="form.pros"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.pros"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.applicationF)"
                :href="form.applicationF"
                target="_blank"
              >
                <img
                  :src="form.applicationF"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.applicationF)"
                :href="form.pros"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.applicationF)"
                :href="form.applicationF"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.applicationF"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.medical)"
                :href="form.medical"
                target="_blank"
              >
                <img
                  :src="form.medical"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.medical)"
                :href="form.medical"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.medical)"
                :href="form.medical"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.medical"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <a
                v-if="isImage(form.parent)"
                :href="form.parent"
                target="_blank"
              >
                <img
                  :src="form.parent"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.parent)"
                :href="form.parent"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.parent)"
                :href="form.paremt"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.parent"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell>

            <TableDataCell>
              <a
                v-if="isImage(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
              >
                <img
                  :src="form.twobytwo"
                  style="max-width: 100%; max-height: 100px"
                />
              </a>
              <a
                v-else-if="isPdf(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
                class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs"
                >PDF</a
              >
              <a
                v-else-if="isDoc(form.twobytwo)"
                :href="form.twobytwo"
                target="_blank"
                class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs"
                >DOC FILE</a
              >
              <a
                v-else
                :href="form.twobytwo"
                target="_blank"
                class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >MISSING</a
              ></TableDataCell
            >
            <TableDataCell>
              <template v-if="isComplete(form)">
                <a
                  @click="updateStatus(form)"
                  target="_blank"
                  class="bg-green-200 text-green-600 py-1 px-5 rounded-full text-xs cursor-pointer transition-colors duration-300 ease-in-out hover:bg-green-300 hover:text-green-700 transform hover:scale-110"
                >
                  COMPLETED
                </a>
              </template>
              <template v-else>
                <a
                  target="_blank"
                  class="bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs"
                >
                  INCOMPLETE
                </a>
              </template></TableDataCell
            > -->
             <TableDataCell class="space-x-4">
               <Link
                  :href="route('applications.updateIncampus', form.id)" 
                  method="PUT" 
                  as="button"
                  class="text-green-400 hover:text-green-600"
                  >Proceed</Link
                >
                <Link
                  :href="route('applications.edit', form.id)"
                  class="text-green-400 hover:text-green-600"
                  >Edit</Link
                >
                <Link
                  :href="route('applications.destroy', form.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >
              </TableDataCell>
              <!-- <TableDataCell
                ><div class="flex item-center justify-center">
                  <div
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                      />
                    </svg>
                  </div>
                  <div
                    class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                      />
                    </svg>
                  </div>
                  <Link
                    :href="route('application.destroy', form.id)"
                    method="DELETE"
                    as="button"
                    class="w-4 mr-2 transform hover:text-red-500 hover:scale-110"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                  </Link></div
              ></TableDataCell> -->
          </TableRow>
        </template>
      </Table>
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
                <button class="mt-12 bg-gold text-white px-8 rounded-lg py-2">Complete</button>
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