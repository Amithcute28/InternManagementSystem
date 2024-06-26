    <script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";
import { initFlowbite } from "flowbite";
import { onMounted } from "vue";
import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import defaultProfileImage from "@/assets/defaultProfile.jpg";
import moment from 'moment';

const props = defineProps({
  newstudents: Object,
  newstudentsbeed: Array,
  filters: Object,
});
const studentProfile = ref(props.newstudents.profile);
const errorLoadingImage = ref(false);

function handleImageError() {
  errorLoadingImage.value = true;
}

const studentProfileImage = computed(() => {
  return errorLoadingImage.value
    ? defaultProfileImage
    : `storage/${studentProfile.value}`;
});

const search = ref(props.filters.search);
const perPage = ref(5);

watch(search, (value) => {
  router.get(
    "newstudents",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

function getTags() {
  router.get(
    "newstudents",
    { perPage: perPage.value },
    {
      preserveState: true,
      replace: true,
    }
  );
}


onMounted(() => {
  initFlowbite();
});


const totalNewStudents = props.newstudentsbeed.length;
console.log(totalNewStudents);


const formatDate = (date) => moment(date).format('YYYY-MM-DD HH:mm:ss');
</script>

    <template>
  <Head title="New Interns" />

  <AdminLayout>
    <div class="max-w-7xl mx-auto mt-16">
      <div>
        <p class="text-2xl font-semibold ml-4">New Interns</p>
        <div
          class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4"
        >
          <div class="flex items-center flex-1 space-x-4">
            <h5>
              <span class="text-gray-500">All New Interns: </span>
              <span class="dark:text-white">{{ totalNewStudents }}</span>
            </h5>
          </div>
          <div
            class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3"
          >
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
              <div
                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
              >
                <svg
                  class="w-5 h-5 text-gray-500 dark:text-gray-400"
                  aria-hidden="true"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
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
                class="px-4 py-3 w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:ring-0 text-sm"
              >
                <option value="5">5 Per Page</option>
                <option value="10">10 Per Page</option>
                <option value="15">15 Per Page</option>
              </select>
              <!-- Dropdown menu -->
            </div>
            
          </div>
        </div>
        <Table>
          <template #header>
            <TableRow>
             
              <TableHeaderCell>ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Program</TableHeaderCell>
              <TableHeaderCell>Date & Time</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </template>

          <template #default>
            <TableRow
              class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700"
              v-for="newstudent in newstudents.data"
              :key="newstudent.id"
            >
             
              <TableDataCell>{{ newstudent.student_id }}</TableDataCell>
              <TableDataCell
                class="flex items-center px-6 py-2 text-gray-900 whitespace-nowrap dark:text-white"
              >
                <img
                  class="w-8 h-8 rounded-full"
                  :src="studentProfileImage"
                  alt=""
                  @error="handleImageError"
                />
                <div class="pl-3">
                  <div class="text-base font-semibold">
                    {{ newstudent.full_name }}
                  </div>
                  <div class="font-normal text-gray-500">
                    {{ newstudent.email }}
                  </div>
                </div>
              </TableDataCell>
              <TableDataCell>{{ newstudent.program }}</TableDataCell>
               <TableDataCell>{{ formatDate(newstudent.created_at) }}</TableDataCell>

              <TableDataCell class="space-x-4">
                <Link
                  :href="route('newstudents.edit', newstudent.id)"
                  class="text-green-400 hover:text-green-600"
                  >Check</Link
                >
                <Link
                  :href="route('newstudents.destroy', newstudent.id)"
                  method="DELETE"
                  as="button"
                  class="text-red-400 hover:text-red-600"
                  >Delete</Link
                >
                <Link
                  :href="route('newstudents.updateApproved', newstudent.id)"
                  method="PUT"
                  as="button"
                  class="text-green-400 hover:text-red-600"
                  >Approve</Link
                >
              </TableDataCell>
            </TableRow>
          </template>
        </Table>
        <div class="m-2 p-2">
          <Pagination :links="newstudents.links" />
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
