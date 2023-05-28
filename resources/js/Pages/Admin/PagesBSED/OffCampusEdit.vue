<script setup>
import AdminLayoutBSED from "@/Layouts/AdminLayoutBSED.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";

import { ref, computed, onMounted } from "vue";

const props = defineProps({
  offCampus: {
    type: Object,
    required: true,
  },
});

console.log(props.offCampus);

const form = useForm({
  studentId: props.offCampus?.id,
  studentName: props.offCampus?.full_name,
  program: props.offCampus?.program,
  evalForm: null,
});

const submit = () => {
  router.post(route("application.update", props.offCampus?.id), {
    _method: "put",
    studentId: form.studentId,
    studentName: form.studentName,
    program: form.program,
    evalForm: form.evalForm,
  });
};

let currentRoute = ref("");

const routeTitle = (route) => {
  if (route == "schools/create") return "Schools Create";

  const routeLabel =
    route?.toString().charAt(0).toUpperCase() + route.substring(1);

  return routeLabel;
};

onMounted(() => {
  currentRoute.value = routeTitle(window.location.pathname.substring(1));
});
</script>



<template>
  <AdminLayoutBSED>
    <Head title="Create student" />

    <div class="max-w-7xl mx-auto py-4">
      <div class="flex justify-between">
        <Link
          :href="route('applications.offCampusApplication')"
          class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
          >Back</Link
        >
      </div>
      <div class="mx-auto w-full max-w-[550px] bg-white">
        <form
          class="py-6 px-9"
          @submit.prevent="submit"
          action="https://formbold.com/s/FORM_ID"
          method="POST"
        >
          <div class="mb-5">
            <label
              for="studentId"
              class="mb-3 block text-base font-medium text-[#07074D]"
            >
              Student ID:
            </label>
            <input
              type="text"
              v-model="form.studentId"
              name="studentId"
              id="studentId"
              placeholder="Name of the School"
              :disabled="true"
              class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
          </div>

          <div class="mb-5">
            <label
              for="schoolName"
              class="mb-3 block text-base font-medium text-[#07074D]"
            >
              Name:
            </label>
            <input
              type="text"
              v-model="form.studentName"
              name="studentName"
              id="studentName"
              placeholder="Address of the school"
              :disabled="true"
              class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
          </div>

          <div class="mb-5">
            <label
              for="schoolName"
              class="mb-3 block text-base font-medium text-[#07074D]"
            >
              Program:
            </label>
            <input
              type="text"
              v-model="form.program"
              name="program"
              id="program"
              :disabled="true"
              placeholder="Address of the school"
              class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
            />
          </div>

          <div class="mb-6 pt-4">
            <label class="mb-5 block text-xl font-semibold text-[#07074D]">
              Upload Evaluation Form
            </label>

            <div class="mb-8">
              <input
                type="file"
                @input="form.evalForm = $event.target.files[0]"
                name="evalForm"
                id="evalForm"
                class="sr-only"
              />
              <label
                for="evalForm"
                class="relative flex min-h-[200px] items-center justify-center rounded-md border border-dashed border-[#e0e0e0] p-12 text-center"
              >
                <div>
                  <span class="mb-2 block text-xl font-semibold text-[#07074D]">
                    Drop files here
                  </span>
                  <span class="mb-2 block text-base font-medium text-[#6B7280]">
                    Or
                  </span>
                  <span
                    class="inline-flex rounded border border-[#e0e0e0] py-2 px-7 text-base font-medium text-[#07074D]"
                  >
                    Browse
                  </span>
                </div>
              </label>
            </div>

            <div
              class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8"
              v-if="form.evalForm"
            >
              <div class="flex items-center justify-between">
                <span
                  class="truncate pr-3 text-base font-medium text-[#07074D]"
                >
                  {{ form.evalForm.name }}
                </span>
                <button class="text-[#07074D]">
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

          <div>
            <button
              type="submit"
              class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </AdminLayoutBSED>
</template>
