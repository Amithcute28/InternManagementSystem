<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Datepicker from "flowbite-datepicker/Datepicker";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, router, useRemember } from "@inertiajs/vue3";
import { onMounted } from "vue";
import flatpickr from "flatpickr";
import { ref, watch, reactive, computed } from "vue";
import "flatpickr/dist/themes/light.css";
import Multiselect from "@vueform/multiselect";

// initialize components based on data attribute selectors
onMounted(() => {
  flatpickr(".flatpickr", {});
});

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },

  provinces: Array,

  cities: Array,

  zipcode: Object,

  zipcodes: Array,

  errors: Object,

  province_zip: Object,

  city_zip: Object,

  provinces_zip: Array,

  cities_zip: Array,

  zipcode_zip: Array,
});

const formFields = useForm({
  skills: [],
  birthday: "",
  gender: "",
  relationship: "",
  nationality: "",
  contact_number: "",
  province: "",
  city: "",
  barangay: "",
  zip_code: "",
  guardian_name: "",
  guardian_contact: "",
  profile: "",
  terms: false,
});

console.log(props.cities);
const submit = () => {
  formFields.post(route("user.updateNewIntern", props.user?.id), {
    preserveState: true,
    preserveScroll: true,
    only: ["errors"],
  });
};

const fetchCities = (province) => {
  router.get(
    `/cities/${province}`,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["cities"],
      onSuccess: (page) => {
        formFields.city = page.props.cities || [];
      },
    }
  );
};

const fetchZipCode = (province, city) => {
  router.get(
    `/zipcodes/${province}/${city}`,
    {},
    {
      preserveState: true,
      preserveScroll: true,
      only: ["zipcode"],
      onSuccess: (page) => {
        formFields.zip_code = Array.isArray(page.props.zipcode)
          ? page.props.zipcode.join(",")
          : "";

        console.log(props.zipcode);
      },

      onError: () => {
        formFields.zip_code = Array.isArray(props.zipcode)
          ? props.zipcode.join(",")
          : "";

        console.log(props.zipcode);
      },
    }
  );
};

const showInvalidZipCodeMessage = ref(false);

const handleZipCodeChange = async () => {
  const zipCode = formFields.zip_code;
  if (zipCode) {
    if (!Array.isArray(props.zipcodes) || props.zipcodes.length === 0) {
      // Handle the case where props.zipcodes is undefined or empty
      console.error("ZIP codes list is empty or undefined.");
      return;
    }

    if (!props.zipcodes.includes(zipCode)) {
      showInvalidZipCodeMessage.value = true;
      props.errors.zip_code = "ZIP code does not exist"; // Set specific error message
      return;
    }

    router.get(
      `/getProvinceAndCity/${zipCode}`,
      {},
      {
        preserveState: true,
        preserveScroll: true,
        only: [
          "zipcode_zip",
          "city_zip",
          "province_zip",
          "provinces",
          "cities",
          "errors",
        ],

        onSuccess: (page) => {
          showInvalidZipCodeMessage.value = false;
          formFields.province = page.props.province_zip;
          formFields.city = page.props.city_zip;
          formFields.zip_code = Array.isArray(page.props.zipcode_zip)
            ? page.props.zipcode_zip.join(",")
            : "";

          console.log("Received province:", props.province_zip);
          console.log("Received city:", props.city_zip);
        },

        onError: () => {
          formFields.province = props.province_zip;
          formFields.city = props.city_zip;
          formFields.zip_code = Array.isArray(props.zipcode_zip)
            ? props.zipcode_zip.join(",")
            : "";

          console.log(props.zipcode);
        },
      }
    );
  }
};

watch(
  () => formFields.zip_code,
  async (newZipCode, oldZipCode) => {
    if (newZipCode !== oldZipCode && newZipCode) {
      await handleZipCodeChange();
    }
  },
  { immediate: true }
);

// Watch for changes in the ZIP code input field

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
          <div class="hidden md:flex flex items-center space-x-2">
            <h1 class="font-bold text-white uppercase">
              New intern, Please fill up the required information to continue!
            </h1>
          </div>

          <!-- login button for big screen -->
          <div class="flex items-center space-x-1">
            <div>
              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="font-bold py-2 px-3 bg-gold hover:bg-yellow-400 text-yellow-100 hover:text-yellow-800 rounded transition duration-300 ease-in-out"
                >Log out</Link
              >
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
            <div class="relative z-1 w-full mb-6 group">
              <Multiselect
                v-model="formFields.skills"
                :style="{ width: '300px' }"
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
                  v-model="formFields.birthday"
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
                v-model="formFields.gender"
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

            <div class="relative z-0 w-full mb-6 group">
              <select
                id="relationship"
                v-model="formFields.relationship"
                :class="{ 'border-red-500': errors.relationship }"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option value="" disabled hidden>Relationship Status</option>
                <option>Married</option>
                <option>Single</option>
              </select>
              <div v-if="errors.relationship" class="text-red-500 text-sm mt-5">
                {{ errors.relationship }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="nationality"
                :class="{ 'border-red-500': errors.nationality }"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="formFields.nationality"
                autocomplete="nationality"
              />
              <label
                for="nationality"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Nationality</label
              >
              <div v-if="errors.nationality" class="text-red-500 text-sm mt-5">
                {{ errors.nationality }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="contact_number"
                :class="{ 'border-red-500': errors.contact_number }"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="formFields.contact_number"
                autocomplete="contact_number"
              />
              <label
                for="contact_number"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Contact Number</label
              >
              <div
                v-if="errors.contact_number"
                class="text-red-500 text-sm mt-5"
              >
                {{ errors.contact_number }}
              </div>
            </div>

            <!-- <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="home_address"
                :class="{ 'border-red-500': errors.home_address }"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="form.home_address"
                autocomplete="home_address"
              />
              <label
                for="home_address"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Home Address</label
              >
              <div v-if="errors.home_address" class="text-red-500 text-sm mt-5">
                {{ errors.home_address }}
              </div>
            </div> -->

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_name"
                :class="{ 'border-red-500': errors.guardian_name }"
                class="block px-5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="formFields.guardian_name"
                autocomplete="guardian_name"
              />
              <label
                for="guardian_name"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Name</label
              >
              <div
                v-if="errors.guardian_name"
                class="text-red-500 text-sm mt-5"
              >
                {{ errors.guardian_name }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="guardian_contact"
                :class="{ 'border-red-500': errors.guardian_contact }"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="formFields.guardian_contact"
                autocomplete="guardian_contact"
              />
              <label
                for="guardian_contact"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Guardian Contact No.</label
              >
              <div
                v-if="errors.guardian_contact"
                class="text-red-500 text-sm mt-5"
              >
                {{ errors.guardian_contact }}
              </div>
            </div>
            <div class="relative z-0 w-full mb-6 group">
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
                    @input="formFields.profile = $event.target.files[0]"
                    class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                  />
                </label>
                <br />
              </div>
              <div
                :class="{
                  'bg-red-500': errors.profile,
                }"
                class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                v-if="formFields.profile"
              >
                <div class="flex items-center justify-between">
                  <span
                    class="truncate pr-3 text-base font-medium text-[#07074D]"
                  >
                    {{ formFields.profile.name }}
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
              <div v-if="errors.profile" class="text-red-500 text-sm mt-5">
                {{ errors.profile }}
              </div>
            </div>
            <!-- "sm:col-span-2" -->
          </div>

          <h3>Home Address</h3>

          <div class="grid md:grid-cols-3 md:gap-6 p-2">
            <div class="relative z-0 w-full mb-6 group">
              <select
                id="provinces"
                v-model="formFields.province"
                @change="fetchCities(formFields.province)"
                :class="{ 'border-red-500': errors.province }"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option value="">Select Province</option>
                <option
                  v-for="province in provinces"
                  :key="province"
                  :value="province"
                >
                  {{ province }}
                </option>
              </select>
              <div v-if="errors.major_area" class="text-red-500 text-sm mt-5">
                {{ errors.major_area }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <select
                id="cities"
                v-model="formFields.city"
                @change="fetchZipCode(formFields.province, formFields.city)"
                :class="{ 'border-red-500': errors.city }"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                <option value="">Select City/Municipality</option>
                <option v-for="city in cities" :key="city" :value="city">
                  {{ city }}
                </option>
              </select>
              <div v-if="errors.major_area" class="text-red-500 text-sm mt-5">
                {{ errors.major_area }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="zip_code"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                v-model="formFields.zip_code"
                placeholder=" "
                autocomplete="zip_code"
                @input="handleZipCodeChange"
              />
              <label
                for="zip_code"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >ZIP Code</label
              >
              <div v-if="errors.zip_code" class="text-red-500 text-sm mt-5">
                {{ errors.zip_code }}
              </div>
            </div>

            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="barangay"
                :class="{ 'border-red-500': errors.barangay }"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" "
                v-model="formFields.barangay"
                autocomplete="barangay"
              />
              <label
                for="barangay"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Barangay</label
              >
              <div v-if="errors.barangay" class="text-red-500 text-sm mt-5">
                {{ errors.barangay }}
              </div>
            </div>
            <!-- "sm:col-span-2" -->
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
/* or */
/* @import './path/to/node_modules/@vueform/multiselect/themes/tailwind.css'; */
</style>