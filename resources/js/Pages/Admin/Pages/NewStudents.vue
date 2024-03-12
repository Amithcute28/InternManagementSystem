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

// initialize components based on data attribute selectors
onMounted(() => {
  initFlowbite();
});

// const props = defineProps({
//   newstudents: {
//     type: [Array, Object],
//     required: true,
//   },
// });

const totalNewStudents = props.newstudentsbeed.length;
console.log(totalNewStudents);
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
            <!-- <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="none" viewbox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        Update stocks 1/250
                    </button>
                    <button type="button" class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        Export
                    </button> -->
          </div>
        </div>
        <Table>
          <template #header>
            <TableRow>
              <!-- <th scope="col" class="p-4">
                <div class="flex items-center">
                  <input
                    id="checkbox-all-search"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label for="checkbox-all-search" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </th> -->
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
              <!-- <td class="w-4 p-4 bg-white">
                <div class="flex items-center">
                  <input
                    id="checkbox-table-search-1"
                    type="checkbox"
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                  />
                  <label for="checkbox-table-search-1" class="sr-only"
                    >checkbox</label
                  >
                </div>
              </td> -->

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
              <TableDataCell>{{ newstudent.created_at }}</TableDataCell>
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
