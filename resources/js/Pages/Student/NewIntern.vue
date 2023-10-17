<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { ref } from "vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  skills: "",
  birthday: "",
  gender: "",
  relationship: "",
  nationality: "",
  contact_number: "",
  home_address: "",
  zip_code: "",
  guardian_name: "",
  guardian_contact: "",
  profile: "",
  terms: false,
});

const submit = () => {
  form.post(route("user.updateNewIntern", props.user?.id), {
    _method: "put",
  });
};

const removeImage = (field) => {
  // Clear the file input value
  document.getElementById(field).value = "";

  // Reset the form data for the field
  form[field] = null;
};
</script>
<template>
  <div>
    <nav class="bg-blue border-b-2 border-gold">
      <div class="max-w-7xl mx-auto px-6 md:px-14">
        <div class="flex justify-start space-x-32">
          <!-- logo -->
          <div>
            <a
              href="#home"
              class="block text-white text-lg font-extrabold flex items-center py-3 px-2"
            >
              <img src="@/Assets/logo.png" class="w-12 h-12 mr-3" />
              <span>Prac<span class="text-yellow-400">Teach.</span></span>
            </a>
          </div>

          <!-- primary nav -->
          <div class="hidden md:flex flex items-center space-x-4">
            <h1 class="font-bold text-white uppercase">
              New intern, Please fill up the required information to continue!
            </h1>
          </div>

          <!-- login button for big screen -->
          <div class="flex items-center space-x-1">
            <div v-if="canLogin">
              <a
                :href="route('dashboard')"
                v-if="$page.props.auth.user"
                class="text-gray-100 py-2 px-3"
                >Dashboard</a
              >
              <template v-else>
                <a :href="route('login')" class="text-gray-100 py-2 px-3"
                  >Login</a
                >
                <a
                  v-if="canRegister"
                  :href="route('register')"
                  class="font-bold py-2 px-3 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out"
                  >Register</a
                >
              </template>
            </div>

            <button class="p-4 focus:outline-none focus:bg-blue-200 md:hidden">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="w-6 h-6"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </nav>
    <div class="flex items-center justify-center">
      <div class="mt-8">
        <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
          <div class="grid md:grid-cols-3 md:gap-6 p-2">
            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="skills"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.skills"
                required
                autofocus
                autocomplete="skills"
              />
              <label
                for="skills"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Skills</label
              >
              <InputError class="mt-2" :message="form.errors.skills" />
            </div>

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
                >Relationship status</label
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
              <InputError class="mt-2" :message="form.errors.contact_number" />
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
                class="block px-5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
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

            <div class="relative z-0 w-full mb-7 group">
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
                >Guardian Contact No.</label
              >
              <InputError
                class="mt-2"
                :message="form.errors.guardian_contact"
              />
            </div>
            <div class="sm:col-span-2">
              <label
                for="profile"
                class="block text-sm font-medium leading-6 text-gray-900"
                >Profile Picture</label
              >
              <!-- <div class="mt-2">
              <label>
                <input
                  id="profile"
                  name="profile"
                  type="file"
                  @input="form.profile = $event.target.files[0]"
                  class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700"
                /><br />
              </label>
            </div> -->
              <div class="mt-4">
                <label
                  for="profile"
                  class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white"
                >
                  <fa :icon="['fas', 'file-upload']" class="px-2 fa-lg" />
                  Upload File</label
                >

                <label>
                  <input
                    id="profile"
                    name="profile"
                    type="file"
                    @input="form.profile = $event.target.files[0]"
                    class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                  />
                </label>
                <br />
              </div>
              <div
                class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                v-if="form.profile"
              >
                <div class="flex items-center justify-between">
                  <span
                    class="truncate pr-3 text-base font-medium text-[#07074D]"
                  >
                    {{ form.profile.name }}
                  </span>
                  <button
                    type="button"
                    class="text-[#07074D]"
                    @click="removeImage('profile')"
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
          <button
            type="submit"
            class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-gold hover:bg-gold/80 focus:bg-gold/90 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4"
          >
            Submit
          </button>
        </form>
      </div>
    </div>
  </div>
</template>