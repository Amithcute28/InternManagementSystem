<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { ref } from "vue";

const props = defineProps({
  errors: Object,
});

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

const form = useForm({
  student_id: "",
  program: "",
  full_name: "",
  email: "",
  password: "",
  password_confirmation: "",
  full_name: "",
  email: "",

  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>
    
    <template>
  <Head title="Register" />
  <section class="flex flex-col md:flex-row h-screen items-center">
    <div class="bg-white-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
      <img
        src="@/Assets/registerlogo21.jpg"
        alt=""
        class="w-full h-full object-cover"
      />
    </div>

    <div
      class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full md:max-w-md lg:max-w-full md:mx-auto md:mx-0 md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12 z-20 mx-6 flex items-center"
    >
      <div class="">
         <h1
          class="text-4xl md:text-4xl font-bold leading-tight mt-12 flex justify-center"
        >
          Sign Up
        </h1>
        <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
          <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
              <input
                type="text"
                id="student_id"
                class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
                placeholder=" "
                v-model="form.student_id"
                required
                autocomplete="student_id"
              />
              <label
                for="student_id"
                class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
                >Student ID
              </label>
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
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="text"
              id="full_name"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.full_name"
              required
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
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.email"
              required
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
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-blue bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.password"
              required
              autocomplete="password"
            />
            <label
              for="password"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Password</label
            >
            <InputError class="mt-2" :message="errors.password" />
          </div>

          <div class="relative z-0 w-full mb-6 group">
            <input
              type="password"
              id="password_confirmation"
              class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:border-blue peer"
              placeholder=" "
              v-model="form.password_confirmation"
              required
              autocomplete="password_confirmation"
            />
            <label
              for="password_confirmation"
              class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
              >Confirm Password</label
            >
            <InputError class="mt-2" :message="errors.password_confirmation" />
          </div>

          <div class="flex justify-center">
            <button
              type="submit"
              class="w-80 py-2.5 block bg-gold hover:bg-gold/80 focus:bg-gold/90 text-white font-semibold rounded-lg px-4 py-3 mt-3"
            >
              Register
            </button>
          </div>
          <p
            class="inline-block align-bottom mt-8 flex justify-center text-gray-700"
          >
            Already registered?&nbsp;<a
              :href="route('login')"
              class="text-blue-500 hover:text-blue-700 font-semibold"
              >Login</a
            >
          </p>
        </form>
      </div>
    </div>
  </section>
</template>
    