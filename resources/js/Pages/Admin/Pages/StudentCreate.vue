<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
  application_forms: {
    type: Object,
    default: () => {},
  },
  errors: Object,
});

const form = useForm({
  student_id: "",
  password: "",
  password_confirmation: "",
  program: "",
  year_level: "",
  full_name: "",
  email: "",
  birthday: "",
  gender: "",
  relationship: "",
  nationality: "",
  contact_number: "",
  home_address: "",
  zip_code: "",
  guardian_name: "",
  guardian_contact: "",
  terms: false,
});

const submit = () => {
  form.post(route("students.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <AdminLayout>
    <Head title="Create student" />

    <div class="bg-white pb-10 px-10 rounded-xl shadow-xl mt-2">
      <div
        class="flex items-center justify-between space-x-2 ml-3 font-semibold text-gray-900 leading-8"
      >
        <span class="tracking-wide">About</span>
        <Link
          :href="route('students.index')"
          class="px-3 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded m-4"
          >Back</Link
        >
      </div>
      <div class="text-gray-700">
        <form @submit.prevent="submit" method="POST" action="/upload"
        enctype="multipart/form-data">
          <div class="grid md:grid-cols-2 text-sm md:gap-x-4">
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

            <div class="grid md:grid-cols-2 md:gap-4">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="program"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.program"
                  required
                  autofocus
                  autocomplete="program"
                />
                <label
                  for="program"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Program</label
                >
                <InputError class="mt-2" :message="form.errors.program" />
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="year_level"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.year_level"
                  required
                  autofocus
                  autocomplete="year_level"
                />
                <label
                  for="year_level"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Year Level</label
                >
                <InputError class="mt-2" :message="form.errors.year_level" />
              </div>
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

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="password"
                id="password"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.password"
                required
                autofocus
                autocomplete="password"
              />
              <label
                for="password"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Password</label
              >
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="password"
                id="password_confirmation"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.password_confirmation"
                required
                autofocus
                autocomplete="password_confirmation"
              />
              <label
                for="password_confirmation"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Confirm Password</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
              />
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="birthday"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.birthday"
                  required
                  autofocus
                  autocomplete="birthday"
                />
                <label
                  for="birthday"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Birthday</label
                >
                <InputError class="mt-2" :message="form.errors.birthday" />
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="gender"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.gender"
                  required
                  autofocus
                  autocomplete="gender"
                />
                <label
                  for="gender"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Gender</label
                >
                <InputError class="mt-2" :message="form.errors.gender" />
              </div>
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="text"
                  id="relationship"
                  class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                  placeholder=" "
                  v-model="form.relationship"
                  required
                  autofocus
                  autocomplete="relationship"
                />
                <label
                  for="relationship"
                  class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                  >Relationship</label
                >
                <InputError class="mt-2" :message="form.errors.relationship" />
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

            <div class="relative z-0 w-full mb-6 group">
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
            </div>

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
          </div>

          <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
              <h2 class="text-base font-semibold leading-7 text-gray-900">
                Application Form
              </h2>
              <p class="mt-1 text-sm leading-6 text-gray-600">
                The practice teaching internship provides a chance for
                individuals pursuing a career in teaching to acquire hands-on
                teaching experience in a real classroom environment.
              </p>

              <div
                class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6"
              >
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
                      <span
                        v-if="errors.medical"
                        class="text-red-500 text-sm"
                        >{{ errors.medical }}</span
                      >
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
                      <span
                        v-if="errors.twobytwo"
                        class="text-red-500 text-sm"
                        >{{ errors.twobytwo }}</span
                      >
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <button
            type="submit"
            class="flex justify-center block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3"
          >
            Create student
          </button>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
