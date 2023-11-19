<script setup>
import ModalDialog from "@/Components/ModalDialog.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  school: {
    type: Object,
  },
});

console.log(props.school);

const modalActive = ref(null);
const toggleModal = () => {
  modalActive.value = !modalActive.value;
};

const form = useForm({
  schoolName: props.school?.school_name,
  schoolAddress: props.school?.school_address,
  schoolLogo: null,
  required_programs: props.school?.required_programs,
  skills: props.school?.skills,
});

const submit = () => {
  router.post(route("schools.update", props.school?.id), {
    _method: "put",
    schoolName: form.schoolName,
    schoolAddress: form.schoolAddress,
    schoolLogo: form.schoolLogo,
    required_programs: form.required_programs,
    skills: form.skills,
  });
};
</script>

<template>
  <form
    class="py-2"
    @submit.prevent="submit"
    action="https://formbold.com/s/FORM_ID"
    method="POST"
  >
    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-1 mb-5">
        <input
          type="text"
          id="schoolName"
          class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
          placeholder=" "
          v-model="form.schoolName"
          required
          autofocus
          autocomplete="schoolName"
        />
        <label
          for="schoolName"
          class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 left-1"
          >Student ID</label
        >
        <InputError class="mt-2" :message="form.errors.schoolName" />
      </div>
      <div class="col-span-1 mb-5">
        <label
          for="schoolName"
          class="mb-3 block text-base font-medium text-[#07074D]"
        >
          School Address:
        </label>
        <input
          type="text"
          v-model="form.schoolAddress"
          name="schoolAddress"
          id="schoolAddress"
          placeholder=" "
          class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
    </div>

    <div class="grid grid-cols-2 gap-5">
      <div class="col-span-1 mb-5">
        <label
          for="schoolName"
          class="mb-3 block text-base font-medium text-[#07074D]"
        >
          Needed Program:
        </label>
        <input
          type="text"
          v-model="form.required_programs"
          name="required_programs"
          id="required_programs"
          placeholder=" "
          class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
      <div class="col-span-1 mb-5">
        <label
          for="schoolName"
          class="mb-3 block text-base font-medium text-[#07074D]"
        >
          Additional Skills:
        </label>
        <input
          type="text"
          v-model="form.skills"
          name="schoolAddress"
          id="skills"
          placeholder=" "
          class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
        />
      </div>
    </div>

    <div class="mb-6 pt-4">
      <label class="mb-5 block text-xl font-semibold text-[#07074D]">
        Upload Logo
      </label>

      <div class="mb-8">
        <input
          type="file"
          @input="form.schoolLogo = $event.target.files[0]"
          name="schoolLogo"
          id="schoolLogo"
          class="sr-only"
        />
        <label
          for="schoolLogo"
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
        v-if="form.schoolLogo"
      >
        <div class="flex items-center justify-between">
          <span class="truncate pr-3 text-base font-medium text-[#07074D]">
            {{ form.schoolLogo.name }}
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
        Add School
      </button>
    </div>
  </form>
</template>

