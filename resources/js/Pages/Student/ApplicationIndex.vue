<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
  application_forms: {
    type: Object,
    default: () => {},
  },
  errors: Object,
});

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

const isFormLoading = ref(false);

async function storeApplication() {
  isFormLoading.value = true;
  await form.post("/application");
  _method: "put";
  isFormLoading.value = false;
  form.eslip = "";
  form.psa = "";
  form.pros = "";
  form.applicationF = "";
  form.medical = "";
  form.parent = "";
  form.twobytwo = "";
}
</script>



<template>
  <Head title="Application" />

  <UserLayout>
    <div class="py-4 mt-16">
      <!-- <h1> Student Profile,  {{ $page.props.auth.user.name }}</h1> -->
      <form
        v-if="!isFormLoading"
        @submit.prevent="storeApplication"
        method="POST"
        action="/upload"
        enctype="multipart/form-data"
      >
        <div class="space-y-12">
          <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900">
              Application Form
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
              The practice teaching internship provides a chance for individuals
              pursuing a career in teaching to acquire hands-on teaching
              experience in a real classroom environment.
            </p>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="sm:col-span-2 sm:col-start-1">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Entrance Slip</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="eslip"
                      name="eslip"
                      type="file"
                      @input="form.eslip = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.eslip" class="text-red-500 text-sm">{{
                      errors.eslip
                    }}</span>
                  </label>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >PSA Livebirth</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="psa"
                      name="psa"
                      type="file"
                      @input="form.psa = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.psa" class="text-red-500 text-sm">{{
                      errors.psa
                    }}</span>
                  </label>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Prospectus</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="pros"
                      name="pros"
                      type="file"
                      @input="form.pros = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.pros" class="text-red-500 text-sm">{{
                      errors.pros
                    }}</span>
                  </label>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Application Form</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="applicationF"
                      name="applicationF"
                      type="file"
                      @input="form.applicationF = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span
                      v-if="errors.applicationF"
                      class="text-red-500 text-sm"
                      >{{ errors.applicationF }}</span
                    >
                  </label>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Medical Certificate</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="medical"
                      name="medical"
                      type="file"
                      @input="form.medical = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.medical" class="text-red-500 text-sm">{{
                      errors.medical
                    }}</span>
                  </label>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Parent's Permit</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="parent"
                      name="parent"
                      type="file"
                      @input="form.parent = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.parent" class="text-red-500 text-sm">{{
                      errors.parent
                    }}</span>
                  </label>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >2x2 ID</label
                >
                <div class="mt-2">
                  <label>
                    <input
                      id="twobytwo"
                      name="twobytwo"
                      type="file"
                      @input="form.twobytwo = $event.target.files[0]"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                    /><br />
                    <span v-if="errors.twobytwo" class="text-red-500 text-sm">{{
                      errors.twobytwo
                    }}</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
          <button
            type="button"
            class="text-sm font-semibold leading-6 text-gray-900"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="isFormLoading"
            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
          >
            Submit
          </button>
        </div>
      </form>
    </div>
  </UserLayout>
</template>