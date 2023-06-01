<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted, computed } from "vue";

const props = defineProps({
  application_forms: {
    type: Array,
    default: () => {},
  },

  errors: Object,
  files: {
    type: Object,
  },
});

console.log(props.application_forms);

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

const applicationForms = ref(props.application_forms);

async function storeApplication() {
  isFormLoading.value = true;

  const formData = new FormData();
  if (form.eslip) {
    formData.append("eslip", form.eslip);
  }
  if (form.psa) {
    formData.append("psa", form.psa);
  }
  if (form.pros) {
    formData.append("pros", form.pros);
  }
  if (form.applicationF) {
    formData.append("applicationF", form.applicationF);
  }
  if (form.medical) {
    formData.append("medical", medical);
  }
  if (form.parent) {
    formData.append("parent", form.parent);
  }
  if (form.twobytwo) {
    formData.append("twobytwo", form.twobytwo);
  }
  await form.post("/application", {
    headers: {
      "Content-Type": "multipart/form-data",
    },
  });
  _method: "put";
  isFormLoading.value = false;
}

const removeImage = () => {
  form.eslip = null;
  form.psa = null;
  form.pros = null;
  form.applicationF = null;
  form.medical = null;
  form.parent = null;
  form.twobytwo = null;
};

const buttonText = computed(() => {
  return applicationForms.value.length > 0 ? "Update" : "Submit";
});

const handleFileChange = (event) => {
  const file = event.target.files[0];
  form.eslip = file;
};
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
          <div class="rounded pb-12 bg-white px-14 py-10">
            <div class=" grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-6">
              <div class="sm:col-span-2 sm:col-start-1 pb-3">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Entrance Slip</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].eslip
                  "
                >
                  <label
                    for="eslip"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >

                  <label>
                    <input
                      id="eslip"
                      name="eslip"
                      type="file"
                      @input="(event) => (form.eslip = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.eslip" class="text-red-500 text-sm mt-5">
                    {{ errors.eslip }}
                  </div>
                </div>

                <div class="mt-4" v-else-if="props.application_forms[0].eslip">
                  <label
                    for="eslip"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Change File</label
                  >

                  <label>
                    <input
                      id="eslip"
                      name="eslip"
                      type="file"
                      @change="handleFileChange"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].eslip
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ form.eslip ? form.eslip.name : "No file selected" }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="removeImage(form.eslip)"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].eslip"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].eslip }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('eslip')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-2 pb-3">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >PSA Livebirth</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].psa
                  "
                >
                  <label
                    for="psa"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="psa"
                      name="psa"
                      type="file"
                      @input="(event) => (form.psa = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.psa" class="text-red-500 text-sm mt-5">
                    {{ errors.psa }}
                  </div>
                </div>

                <div class="mt-4" v-else-if="props.application_forms[0].psa">
                  <label
                    for="psa"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Change File</label
                  >
                  <label>
                    <input
                      id="psa"
                      name="psa"
                      type="file"
                      @input="(event) => (form.psa = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>
                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].psa
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ form.psa ? form.psa.name : "No file selected" }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage(form.psa)"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].psa"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].psa }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('psa')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Prospectus</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].pros
                  "
                >
                  <label
                    for="pros"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="pros"
                      name="pros"
                      type="file"
                      @input="(event) => (form.pros = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.pros" class="text-red-500 text-sm mt-5">
                    {{ errors.pros }}
                  </div>
                </div>

                <div class="mt-4" v-else-if="props.application_forms[0].pros">
                  <label
                    for="pros"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Change File</label
                  >
                  <label>
                    <input
                      id="pros"
                      name="pros"
                      type="file"
                      @input="(event) => (form.pros = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>
                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].pros
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ form.pros ? form.pros.name : "No file selected" }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('pros')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].pros"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].pros }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('pros')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-2 pb-3">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Application Form</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].applicationF
                  "
                >
                  <label
                    for="applicationF"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="applicationF"
                      name="applicationF"
                      type="file"
                      @input="
                        (event) => (form.applicationF = event.target.files[0])
                      "
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div
                    v-if="errors.applicationF"
                    class="text-red-500 text-sm mt-5"
                  >
                    {{ errors.applicationF }}
                  </div>
                </div>

                <div
                  class="mt-4"
                  v-else-if="props.application_forms[0].applicationF"
                >
                  <label
                    for="applicationF"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Change File</label
                  >
                  <label>
                    <input
                      id="applicationF"
                      name="applicationF"
                      type="file"
                      @input="
                        (event) => (form.applicationF = event.target.files[0])
                      "
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>
                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].applicationF
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{
                        form.applicationF
                          ? form.applicationF.name
                          : "No file selected"
                      }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('applicationF')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].applicationF"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].applicationF }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('applicationF')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="sm:col-span-2 pb-3">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Medical Certificate</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].medical
                  "
                >
                  <label
                    for="medical"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="medical"
                      name="medical"
                      type="file"
                      @input="(event) => (form.medical = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.medical" class="text-red-500 text-sm mt-5">
                    {{ errors.medical }}
                  </div>
                </div>

                <div
                  class="mt-4"
                  v-else-if="props.application_forms[0].medical"
                >
                  <label
                    for="medical"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="medical"
                      name="medical"
                      type="file"
                      @input="(event) => (form.medical = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].medical
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{
                        form.medical ? form.medical.name : "No file selected"
                      }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('medical')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].medical"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].medical }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('medical')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
              <div class="sm:col-span-2">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >Parent's Permit</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].parent
                  "
                >
                  <label
                    for="parent"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="parent"
                      name="parent"
                      type="file"
                      @input="(event) => (form.parent = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.parent" class="text-red-500 text-sm mt-5">
                    {{ errors.parent }}
                  </div>
                </div>

                <div class="mt-4" v-else-if="props.application_forms[0].parent">
                  <label
                    for="parent"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="parent"
                      name="parent"
                      type="file"
                      @input="(event) => (form.parent = event.target.files[0])"
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>
                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].parent
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ form.parent ? form.parent.name : "No file selected" }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('parent')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].parent"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].parent }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('parent')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </div>

              <div class="sm:col-span-2 pb-3">
                <label
                  for="country"
                  class="block text-sm font-medium leading-6 text-gray-900"
                  >2x2 ID</label
                >
                <div
                  class="mt-4"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].twobytwo
                  "
                >
                  <label
                    for="twobytwo"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white mb-5"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Upload File</label
                  >
                  <label>
                    <input
                      id="twobytwo"
                      name="twobytwo"
                      type="file"
                      @input="
                        (event) => (form.twobytwo = event.target.files[0])
                      "
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                  <br />
                  <div v-if="errors.twobytwo" class="text-red-500 text-sm mt-5">
                    {{ errors.twobytwo }}
                  </div>
                </div>

                <div
                  class="mt-4"
                  v-else-if="props.application_forms[0].twobytwo"
                >
                  <label
                    for="twobytwo"
                    class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                  >
                    <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                    Change File</label
                  >

                  <label>
                    <input
                      id="twobytwo"
                      name="twobytwo"
                      type="file"
                      @input="
                        (event) => (form.twobytwo = event.target.files[0])
                      "
                      class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                    />
                  </label>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-if="
                    !props.application_forms ||
                    props.application_forms.length === 0 ||
                    !props.application_forms[0].twobytwo
                  "
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{
                        form.twobytwo ? form.twobytwo.name : "No file selected"
                      }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('twobytwo')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
                </div>

                <div
                  class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                  v-else-if="props.application_forms[0].twobytwo"
                >
                  <div class="flex items-center justify-between">
                    <span
                      class="truncate pr-3 text-base font-medium text-[#07074D]"
                    >
                      {{ props.application_forms[0].twobytwo }}
                    </span>
                    <button
                      type="button"
                      class="text-[#07074D]"
                      @click="() => removeImage('twobytwo')"
                    >
                      <svg
                        width="10"
                        height="10"
                        viewBox="0 0 10 10"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                      >
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 0.279338C0.651787 -0.0931121 1.25565 -0.0931121 1.6281 0.279338L9.72066 8.3719C10.0931 8.74435 10.0931 9.34821 9.72066 9.72066C9.34821 10.0931 8.74435 10.0931 8.3719 9.72066L0.279337 1.6281C-0.0931125 1.25565 -0.0931125 0.651788 0.279337 0.279338Z"
                          fill="currentColor"
                        />
                        <path
                          fill-rule="evenodd"
                          clip-rule="evenodd"
                          d="M0.279337 9.72066C-0.0931125 9.34821 -0.0931125 8.74435 0.279337 8.3719L8.3719 0.279338C8.74435 -0.0931127 9.34821 -0.0931123 9.72066 0.279338C10.0931 0.651787 10.0931 1.25565 9.72066 1.6281L1.6281 9.72066C1.25565 10.0931 0.651787 10.0931 0.279337 9.72066Z"
                          fill="currentColor"
                        />
                      </svg>
                    </button>
                  </div>
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
            :class="{
              'bg-gold': !isSubmitted,
              'bg-blue': isSubmitted,
              'rounded-md px-3 py-2 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': true,
              'hover:bg-gold/70': !isSubmitted && !isFormLoading,
            }"
          >
            {{
              isFormLoading ? "Submitting..." : buttonText ? "Update" : "Submit"
            }}
          </button>
        </div>
      </form>
    </div>
  </UserLayout>
</template>