<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/light.css";
import { onMounted } from "vue";
import Multiselect from "@vueform/multiselect";

onMounted(() => {
  flatpickr(".flatpickr", {});
});

import { ref } from "vue";

const step = ref(1);
const firstName = ref("");
const lastName = ref("");
const email = ref("");
const password = ref("");

function nextStep() {
  step.value++;
}

function prevStep() {
  step.value--;
}

function submitForm() {
  // Submit form logic goes her
}

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },

  errors: Object,
});

const form = useForm({
  skills: [],
  student_id: props.user?.student_id,
  program: props.user?.program,
  year_level: props.user?.year_level,
  full_name: props.user?.full_name,
  email: props.user?.email,
  birthday: props.user?.birthday,
  gender: props.user?.gender,
  relationship: props.user?.relationship,
  nationality: props.user?.nationality,
  contact_number: props.user?.contact_number,
  zip_code: props.user?.zip_code,
  guardian_name: props.user?.guardian_name,
  guardian_contact: props.user?.guardian_contact,
  student_school_name: props.user?.student_school_name,
  student_school_code: props.user?.student_school_code,
  student_shift: props.user?.student_shift,
  profile: null,
});

const onFileChange = (e) => {
  form.profile = e.target.files[0];
};

const submit = () => {
  const formData = new FormData();
  formData.append("_method", "PUT");

  // Append all form fields except the profile picture.
  for (const [key, value] of Object.entries(form)) {
    if (key !== "profile") {
      formData.append(key, value);
    }
  }

  // Append the profile picture only if a new file has been selected.
  if (form.profile instanceof File) {
    formData.append("profile", form.profile);
  }

  router.post(route("user.update", props.user?.id), formData, {
    forceFormData: true,
  });
};
</script>

<template>
  <UserLayout>
    <Head title="Update student" />

    <div class="bg-white pb-10 px-10 rounded-xl shadow-md mt-16">
      <div
        class="flex items-center justify-between space-x-2 ml-3 font-semibold text-gray-900 leading-8"
      >
        <span class="tracking-wide">About</span>
        <Link
          :href="route('user.index')"
          class="px-3 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded m-4"
          >Back</Link
        >
      </div>
      <div class="text-gray-700">
        <form @submit.prevent="submit" action="#" method="POST">
          <div class="grid md:grid-cols-2 text-sm md:gap-x-4 md:gap-y-2">
            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="student_id"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.student_id"
                required
                autofocus
                autocomplete="student_id"
              />
              <label
                for="student_id"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Student ID</label
              >
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

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="full_name"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.full_name"
                required
                autofocus
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
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.email"
                required
                autofocus
                autocomplete="email"
              />
              <label
                for="email"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Email Address</label
              >
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="relative z-1 w-full mb-6 group">
              <Multiselect
                v-model="form.skills"
                :classes="{
                  groupLabelSelected: 'bg-gold-600 text-white',
                  groupLabelSelectedPointed:
                    'bg-gold-600 text-white opacity-90',
                  optionSelected: 'text-white bg-gold-600',
                  optionSelectedPointed: 'text-white bg-gold-600 opacity-90',
                }"
                mode="tags"
                :close-on-select="false"
                :searchable="true"
                :create-option="true"
                :options="[
                  {
                    value: 'Communication and Interpersonal Skills',
                    label: 'Communication and Interpersonal Skills',
                  },
                  {
                    value: 'Subject Knowledge Skills',
                    label: 'Subject Knowledge Skills',
                  },
                  {
                    value: 'Adaptability Skills',
                    label: 'Adaptability Skills',
                  },
                  {
                    value: 'Technological Profiency Skills',
                    label: 'Technological Profiency Skills',
                  },
                  {
                    value: 'Classroom Management Skills',
                    label: 'Classroom Management Skills',
                  },
                  {
                    value: 'Collaboration and Teamwork Skills',
                    label: 'Collaboration and Teamwork Skills',
                  },
                  {
                    value: 'Emotional Support Skills',
                    label: 'Emotional Support Skills',
                  },
                ]"
              />
              <div v-if="errors.skills" class="text-red-500 text-sm mt-5">
                {{ errors.skills }}
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <div class="relative max-w-sm">
                  <div
                    class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                  >
                    <svg
                      class="w-4 h-4 text-gray-500 dark:text-gray-400"
                      aria-hidden="true"
                      xmlns="http://www.w3.org/2000/svg"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                      />
                    </svg>
                  </div>
                  <input
                    type="date"
                    v-model="form.birthday"
                    :class="{ 'border-red-500': errors.birthday }"
                    class="flatpickr bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Birthday"
                  />
                </div>
                <div v-if="errors.birthday" class="text-red-500 text-sm mt-5">
                  {{ errors.birthday }}
                </div>
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <select
                  id="gender"
                  v-model="form.gender"
                  :class="{ 'border-red-500': errors.gender }"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  <option value="" disabled hidden>Gender</option>
                  <option>Male</option>
                  <option>Female</option>
                </select>
                <div v-if="errors.gender" class="text-red-500 text-sm mt-5">
                  {{ errors.gender }}
                </div>
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <select
                  id="relationship"
                  v-model="form.relationship"
                  :class="{ 'border-red-500': errors.relationship }"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  <option value="" disabled hidden>Relationship Status</option>
                  <option>Married</option>
                  <option>Single</option>
                </select>
                <div
                  v-if="errors.relationship"
                  class="text-red-500 text-sm mt-5"
                >
                  {{ errors.relationship }}
                </div>
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="nationality"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.nationality"
                  required
                  autofocus
                  autocomplete="nationality"
                />
                <label
                  for="nationality"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Nationality</label
                >
                <InputError class="mt-2" :message="form.errors.nationality" />
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="contact_number"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.contact_number"
                  required
                  autofocus
                  autocomplete="contact_number"
                />
                <label
                  for="contact_number"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Contact Number</label
                >
                <InputError
                  class="mt-2"
                  :message="form.errors.contact_number"
                />
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="zip_code"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.zip_code"
                  required
                  autofocus
                  autocomplete="zip_code"
                />
                <label
                  for="zip_code"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Zip Code</label
                >
                <InputError class="mt-2" :message="form.errors.zip_code" />
              </div>
            </div>

            <!-- <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="home_address"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.home_address"
                required
                autofocus
                autocomplete="home_address"
              />
              <label
                for="home_address"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Home Address</label
              >
              <InputError class="mt-2" :message="form.errors.home_address" />
            </div> -->

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_name"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.guardian_name"
                required
                autofocus
                autocomplete="guardian_name"
              />
              <label
                for="guardian_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Name</label
              >
              <InputError class="mt-2" :message="form.errors.guardian_name" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_contact"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.guardian_contact"
                required
                autofocus
                autocomplete="guardian_contact"
              />
              <label
                for="guardian_contact"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Contact Number</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.guardian_contact"
              />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="student_school_name"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.student_school_name"
                required
                autofocus
                autocomplete="student_school_name"
              />
              <label
                for="student_school_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >School Name</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.student_school_name"
              />
            </div>

            <div class="grid md:grid-cols-2 md:gap-4">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="student_school_code"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.student_school_code"
                  required
                  autofocus
                  autocomplete="student_school_code"
                />
                <label
                  for="student_school_code"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Code</label
                >
                <InputError
                  class="mt-2"
                  :message="form.errors.student_school_code"
                />
              </div>
              <div class="relative z-0 w-full mb-2 group">
                <select
                  id="shift"
                  v-model="form.student_shift"
                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  <option value="" disabled hidden>Shift</option>
                  <option>First</option>
                  <option>Second</option>
                </select>
                <InputError class="mt-2" :message="form.errors.student_shift" />
              </div>
            </div>
            <div class="relative z-0 w-full group">
              <label
                for="profile"
                class="block mb-2 text-sm font-medium leading-6 text-gray-900"
                >Profile Picture</label
              >

              <input type="file" @change="onFileChange" accept="image/*" />
            </div>
          </div>

          <button
            type="submit"
            class="flex justify-center block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
          >
            Update students
          </button>
        </form>
      </div>
    </div>
  </UserLayout>
</template>

<style>
@import "@vueform/multiselect/themes/tailwind.css";

.multiselect-tag {
  background-color: #f2ce02; /* Change background color */
  color: #fff; /* Change text color */
  border-color: #f6e05e; /* Change border color */
  /* Add any other styles as needed */
}

.multiselect-tag-remove {
  background-color: #fff;
  color: #fff;
  border-color: #fff;
  /* Change background color */
  /* Change text color */
  /* Change border color */
  /* Add any other styles as needed */
}

.multiselect.is-active {
  outline-color: #0743b2;
}
</style>
