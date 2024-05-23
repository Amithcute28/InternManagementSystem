    <script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { reactive, ref } from "vue";
import Swal from "sweetalert2";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Pagination from "@/Components/Pagination.vue";
import { watch } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  approved: Array,
  interns: Array,
  files: Array,
  filters: Array,
});

const search = ref(props.filters.search);
const perPage = ref(5);

watch(search, (value) => {
  router.get(
    "in-campus-application",
    { search: value },
    {
      preserveState: true,
      replace: true,
    }
  );
});

function getTags() {
  router.get(
    "in-campus-application",
    { perPage: perPage.value },
    {
      preserveState: true,
      replace: true,
    }
  );
}

const isImage = (url) => {
  return /\.(jpeg|jpg|png|gif)$/i.test(url);
};

const isPdf = (url) => {
  return /\.(pdf)$/i.test(url);
};

const isDoc = (url) => {
  return /\.(doc|docx)$/i.test(url);
};

const totalInterns = props.interns.length;

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
  document.getElementById("myModal").showModal();
}

const proceedAction = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "Proceeding will perform an action. Are you sure you want to proceed?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, proceed!",
  }).then((result) => {
    if (result.isConfirmed) {
      // If confirmed, proceed with the action
      form.put(route("applications.updateIncampus", id));
    }
  });
};

const deleteAction = (id) => {
  Swal.fire({
    title: "Are you sure?",
    text: "You are about to delete. This action cannot be undone. Are you sure you want to delete?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      form.delete(route("applications.destroy", id));
    }
  });
};
</script>

    <template>
  <Head title="First Shift Application" />

  <AdminLayout>
    <div class="max-w-7xl mx-aut mt-16">
      <div class="flex justify-between">
        <p class="text-2xl font-semibold ml-4">First Shift Application</p>
      </div>

      <div
        class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4"
      >
        <div class="flex items-center flex-1 space-x-4">
          <h5>
            <span class="text-gray-500">All First Shift Applications: </span>
            <span class="dark:text-white">{{ totalInterns }}</span>
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

          </div>
        </div>
      </div>
    </div>

    <div class="">
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
            <TableHeaderCell>Status</TableHeaderCell>
            <TableHeaderCell>Action</TableHeaderCell>
          </TableRow>
        </template>
        <template #default>
          <TableRow
            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700"
            v-for="form in approved.data"
            :key="form.id"
          >
            <TableDataCell>{{ form.student_id }}</TableDataCell>
            <TableDataCell
              class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
            >
              <img
                class="w-8 h-8 rounded-full"
                :src="`storage/${form.profile}`"
                alt=""
              />
              <div class="pl-3">
                <div class="text-base font-semibold">{{ form.full_name }}</div>
                <div class="font-normal text-gray-500">{{ form.email }}</div>
              </div>
            </TableDataCell>
            <TableDataCell>{{ form.program }}</TableDataCell>

            <TableDataCell>
              <button
                @click="openModal(form)"
                class="px-6 py-2 text-white bg-gold hover:bg-indigo-400 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              >
                View
              </button></TableDataCell
            >

            <TableDataCell>
              <template v-if="isComplete(form)">
                <div class="flex items-center">
                  <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div>
                  Completed
                </div>
                <div class="flex items-center">
                  {{ form.created_at }}
                </div>
              </template>
              <template v-else>
                <div class="flex items-center">
                  <div class="h-2.5 w-2.5 rounded-full bg-red-500 mr-2"></div>
                  Incomplete
                </div>
              </template></TableDataCell
            >

            <TableDataCell>
              <div class="flex items-center space-x-2">
                <Link
                  @click="isComplete(form) ? proceedAction(form.id) : null"
                  as="button"
                  class="text-grey-300 hover:text-yellow-300"
                  :style="{
                    'pointer-events': isComplete(form) ? 'auto' : 'none',
                    color: isComplete(form) ? '' : '#ccc',
                  }"
                  ><font-awesome-icon
                    :icon="['far', 'square-caret-right']"
                    class="fa-lg outline-none"
                  />
                </Link>

                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="w-5 h-5 scale-90 transform hover:text-yellow-300 hover:scale-100"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </div>
            </TableDataCell>
          </TableRow>
        </template>
      </Table>
      <div class="m-2 p-2">
        <Pagination :links="approved.links" />
      </div>
    </div>

    <dialog id="myModal" class="p-5 bg-darkWhite rounded-md">
      <div class="flex w-full h-auto justify-between items-center">
        <div
          class="flex h-auto py-3 justify-center items-center text-2xl font-bold"
        >
          In-Campus Application
        </div>
        <div
          onclick="document.getElementById('myModal').close();"
          class="flex w-1/12 h-auto justify-center cursor-pointer"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="#000000"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="feather feather-x"
          >
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
          </svg>
        </div>
      </div>
      <div class="flex items-center flex-col p-10">
        <div class="grid grid-cols-12 gap-6" v-if="applications">
          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="text-lg leading-6 text-black mb-12 flex items-center"
                >Entrance Slip</label
              >
              <a
                v-if="isImage(applications.eslip)"
                :href="applications.eslip"
                target="_blank"
              >
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

          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >PSA Livebirth</label
              >
              <a
                v-if="isImage(applications.psa)"
                :href="applications.psa"
                target="_blank"
              >
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

          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
            <div class="h-44 p-5">
              <label
                for="country"
                class="block text-lg leading-6 text-black mb-12"
                >Prospectus</label
              >
              <a
                v-if="isImage(applications.pros)"
                :href="applications.pros"
                target="_blank"
              >
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

          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
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


          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
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


          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
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

          </div>

          <div
            class="transform hover:scale-105 transition duration-300 shadow-md rounded-lg col-span-12 sm:col-span-6 xl:col-span-3 intro-y bg-white"
          >
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

          </div>
        </div>
      </div>
    </dialog>
  </AdminLayout>
</template>

<style>
dialog[open] {
  animation: appear 0.15s cubic-bezier(0, 1.8, 1, 1.8);
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