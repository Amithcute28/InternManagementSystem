<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, onMounted, computed, watch, reactive } from "vue";
import Swal from "sweetalert2";
import Card from "@/Components/Card.vue";

const props = defineProps({
  application_forms: {
    type: Object,
  },
  errors: {
    type: Object,
  },

  files: {
    type: Object,
  },

  addresses: {
    type: Array,
    default: () => {},
  },
});

const form = useForm({
  // Set the initial value to the existing data if editing, otherwise default to null or ''.
  id: props.application_forms?.id,
  eslip: props.application_forms?.eslip || "",
  psa: props.application_forms?.psa || null,
  pros: props.application_forms?.pros || null,
  applicationF: props.application_forms?.applicationF || null,
  medical: props.application_forms?.medical || null,
  parent: props.application_forms?.parent || null,
  twobytwo: props.application_forms?.twobytwo || null,
  // You can add other fields here as necessary.

  // preserveState tells Inertia to keep the form's state after a page visit.
});

const isLarge = ref(false); // Initially, the button size is normal

const toggleSize = () => {
  isLarge.value = !isLarge.value;
};

const localErrors = reactive({
  eslip: null,
  applicationF: null,
  psa: null,
  pros: null,
  medical: null,
  parent: null,
  twobytwo: null,
  // ... other fields initialized to null ...
});

const isFilePath = (value) => typeof value === "string" && value.length > 0;

const validateAllFields = () => {
  // Validate field as a file path or a File object
  const validateField = (field, file, isFileFn) => {
    if (isFilePath(file)) {
      // Assume file paths to be valid if they are non-empty strings
      localErrors[field] = null;
    } else if (file instanceof File) {
      // Validate the file object
      localErrors[field] = isFileFn(file) ? null : errorMessages[field];
    } else {
      // No file or file path provided
      localErrors[field] = errorMessages.required;
    }
  };

  // Perform validation checks
  validateField("eslip", form.eslip, isPdfFile);
  validateField("applicationF", form.applicationF, isPdfFile);
  validateField("psa", form.psa, isPdfFile);
  validateField("pros", form.pros, isPdfFile);
  validateField("medical", form.medical, isPdfFile);
  validateField("parent", form.parent, isPdfFile);
  validateField("twobytwo", form.twobytwo, isImageFile);

  // ... repeat for other fields ...
};

onMounted(() => {
  validateAllFields();
});

const errorMessages = {
  eslip: "The entrance slip must be a PDF.",
  applicationF: "The application form must be a PDF.",
  psa: "The PSA Livebirth must be a PDF file",
  pros: "The prospectus must be a PDF file",
  medical: "The medical must be a PDF file",
  parent: "The Parent's permit must be a PDF file",
  twobytwo: "The 2x2 ID  must be an image (JPEG, PNG, JPG).",
  required: "This field is required.",

  // Add other fields and their error messages as needed
};

const checkFileRequired = (file, field) => {
  // Check if the file is not provided
  if (!file) {
    localErrors[field] = errorMessages.required;
  }
};

const isPdfFile = (file) =>
  file instanceof File && file.type === "application/pdf";

const isImageFile = (file) =>
  file instanceof File &&
  ["image/jpeg", "image/png", "image/jpg"].includes(file.type);

const setOrClearError = (field, file) => {
  checkFileRequired(file, field);
  if (file) {
    localErrors[field] = isPdfFile(file) ? null : errorMessages[field];
  }
};
`w`;
const setOrClearImage = (field, file) => {
  checkFileRequired(file, field);
  if (file) {
    localErrors[field] = isImageFile(file) ? null : errorMessages[field];
  }
};

watch(
  () => form.eslip,
  (file) => setOrClearError("eslip", file)
);
watch(
  () => form.applicationF,
  (file) => setOrClearError("applicationF", file)
);
watch(
  () => form.psa,
  (file) => setOrClearError("psa", file)
);
watch(
  () => form.pros,
  (file) => setOrClearError("pros", file)
);
watch(
  () => form.medical,
  (file) => setOrClearError("medical", file)
);

watch(
  () => form.parent,
  (file) => setOrClearError("parent", file)
);
watch(
  () => form.twobytwo,
  (file) => setOrClearImage("twobytwo", file)
);

const isFormLoading = ref(false);

const applicationForms = ref(props.application_forms);

console.log(props.application_forms);

const submit = async () => {
  if (form.id) {
    const result = await Swal.fire({
      title: "Are you sure?",
      text: "You're about to update the application!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, update it!",
    });

    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append("_method", "PUT");
      formData.append("id", form.id);

      if (form.eslip instanceof File) {
        formData.append("eslip", form.eslip);
      }

      if (form.psa instanceof File) {
        formData.append("psa", form.psa);
      }

      if (form.pros instanceof File) {
        formData.append("pros", form.pros);
      }

      if (form.applicationF instanceof File) {
        formData.append("applicationF", form.applicationF);
      }

      if (form.medical instanceof File) {
        formData.append("medical", form.medical);
      }

      if (form.parent instanceof File) {
        formData.append("parent", form.parent);
      }

      if (form.twobytwo instanceof File) {
        formData.append("twobytwo", form.twobytwo);
      }
      // Append other fields to formData...

      try {
        await router.post(
          route(
            form.id
              ? "applications.updateInternApplication"
              : "application.store"
          ),
          formData,
          {
            forceFormData: true,
            onSuccess: () => {
              if (Object.keys(props.errors).length === 0) {
                // No validation errors, proceed with success message
                Swal.fire(
                  "Success!",
                  "Your application has been processed.",
                  "success"
                );
              }
            },
            onError: (errors) => {
              isFormLoading.value = false;
              // Update local errors with server validation errors
              localErrors.value = errors;
              const errorMessage = Object.values(errors)
                .map((e) => (Array.isArray(e) ? e.join(", ") : e))
                .join("\n");
              Swal.fire("Validation Error", errorMessage, "error");
            },
          }
        );
      } catch (e) {
        // Network error or other non-validation related error
        console.error("Request error:", e);
        await Swal.fire(
          "Error",
          "There was an error processing your application.",
          "error"
        );
      }
    }
  } else {
    const result = await Swal.fire({
      title: "Are you sure?",
      text: "You're about to submit a new application!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, submit it!",
    });

    if (result.isConfirmed) {
      form.post(route("application.store"), {
        onSuccess: () => {
          if (!Object.keys(props.errors).length) {
            Swal.fire(
              "Success!",
              "Your new application has been submitted.",
              "success"
            ).then(() => {
              // Reload the whole page after showing the success message
              location.reload();
            });

            // Also clear any server-side errors
            // Reset preserveState to false after successful submission
          }
        },
        onError: (errors) => {
          // Update local errors with server validation errors
          localErrors.value = errors;
          const errorMessage = Object.values(errors)
            .map((e) => (Array.isArray(e) ? e.join(", ") : e))
            .join("\n");
          Swal.fire("Validation Error", errorMessage, "error");
        },
      });
    }
  }
};

const deleteIntern = async (fieldName) => {
  const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton:
        "bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 ml-5 rounded",
      cancelButton:
        "bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded",
    },
    buttonsStyling: false,
  });

  const result = await swalWithBootstrapButtons.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "No, cancel!",
    reverseButtons: true,
  });

  if (result.isConfirmed) {
    await router.delete(
      route("applications.deleteInternApplication", {
        id: props.application_forms.id,
        field: fieldName,
      }),
      {
        onSuccess: () => {
          // Update the form object to reflect the deletion
          form[fieldName] = null;

          // If you maintain any additional state related to the file, update it here
          // For example, if you store the file URL, clear it as well
          if (fieldName === "eslip") {
            props.application_forms.eslip = null;
          }
          // ... handle other fields similarly ...

          // Show the success message
          swalWithBootstrapButtons.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success",
          });
        },
      }
    );
  } else if (result.dismiss === Swal.DismissReason.cancel) {
    swalWithBootstrapButtons.fire({
      title: "Cancelled",
      text: "Your file is safe :)",
      icon: "error",
    });
  }
};
const removeImage = (fieldName) => {
  form[fieldName] = null;

  const fileInput = document.getElementById(fieldName);
  if (fileInput) {
    fileInput.value = "";
  }
};

const buttonText = computed(() => {
  return applicationForms.value && applicationForms.value.id
    ? "Update"
    : "Submit";
});

const handleFileChange = (event, fieldName) => {
  const file = event.target.files[0];
  if (file) {
    form[fieldName] = file;
  } else {
    form[fieldName] = null;
  }
};

const getDisplayFileName = (fieldName) => {
  if (form[fieldName] && form[fieldName] instanceof File) {
    return form[fieldName].name;
  } else if (typeof props.application_forms[fieldName] === "string") {
    return props.application_forms[fieldName];
  }

  return "No file selected";
};

const getFileUrl = (fileName) => {
  return "/storage/student/" + fileName;
};
</script>



<template>
  <div>
    <Head title="Application" />
    <UserLayout>
      <div class="py-4 mt-16">
        <form
          v-if="!isFormLoading"
          @submit.prevent="submit"
          method="POST"
          action="/upload"
          enctype="multipart/form-data"
        >
        <div class="flex items-center justify-end gap-x-6">
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
          <div class="space-y-12">
            <div class="grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-2">
              <div>
                <Card>
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
                        !props.application_forms.eslip
                      "
                    >
                      <label
                        for="eslip"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >

                      <label>
                        <input
                          id="eslip"
                          name="eslip"
                          type="file"
                          accept=".pdf"
                          @input="
                            (event) => (form.eslip = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.eslip"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.eslip }}
                      </div>
                    </div>

                    <div class="mt-4" v-else-if="props.application_forms.eslip">
                      <label
                        for="eslip"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >

                      <label>
                        <input
                          id="eslip"
                          name="eslip"
                          type="file"
                          accept=".pdf"
                          @change="(event) => handleFileChange(event, 'eslip')"
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.eslip"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.eslip }}
                      </div>
                    </div>

                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.eslip
                      "
                    >
                      <div class="flex items-center justify-between">
                        <span
                          v-if="form.eslip"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ form.eslip.name }}
                        </span>

                        <span
                          v-else
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          No file selected
                        </span>
                        <button type="button" class="text-[#07074D]">
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
                      v-else-if="props.application_forms.eslip"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.eslip)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("eslip") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('eslip')"
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
                      <span
                        v-if="!form.eslip && !getDisplayFileName('eslip')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div></Card
                >
              </div>

              <div>
                <Card>
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
                        !props.application_forms.psa
                      "
                    >
                      <label
                        for="psa"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="psa"
                          name="psa"
                          type="file"
                          accept=".pdf"
                          @input="(event) => (form.psa = event.target.files[0])"
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.psa"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.psa }}
                      </div>
                    </div>

                    <div class="mt-4" v-else-if="props.application_forms.psa">
                      <label
                        for="psa"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >
                      <label>
                        <input
                          id="psa"
                          name="psa"
                          type="file"
                          accept=".pdf"
                          @change="(event) => handleFileChange(event, 'psa')"
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.psa"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.psa }}
                      </div>
                    </div>
                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.psa
                      "
                    >
                      <div class="flex items-center justify-between">
                        <span
                          v-if="form.psa"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ form.psa.name }}
                        </span>

                        <span
                          v-else
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          No file selected
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

                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-else-if="props.application_forms.psa"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.psa)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("psa") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('psa')"
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
                      <span
                        v-if="!form.psa && !getDisplayFileName('psa')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>
              <div>
                <Card>
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
                        !props.application_forms.pros
                      "
                    >
                      <label
                        for="pros"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="pros"
                          name="pros"
                          type="file"
                          accept=".pdf"
                          @input="
                            (event) => (form.pros = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.pros"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.pros }}
                      </div>
                    </div>

                    <div class="mt-4" v-else-if="props.application_forms.pros">
                      <label
                        for="pros"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >
                      <label>
                        <input
                          id="pros"
                          name="pros"
                          type="file"
                          accept=".pdf"
                          @change="(event) => handleFileChange(event, 'pros')"
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.pros"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.pros }}
                      </div>
                    </div>
                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.pros
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
                      v-else-if="props.application_forms.pros"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.pros)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("pros") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('pros')"
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
                      <span
                        v-if="!form.pros && !getDisplayFileName('pros')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>

              <div>
                <Card>
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
                        !props.application_forms.applicationF
                      "
                    >
                      <label
                        for="applicationF"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="applicationF"
                          name="applicationF"
                          type="file"
                          accept=".pdf"
                          @input="
                            (event) =>
                              (form.applicationF = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.applicationF"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.applicationF }}
                      </div>
                    </div>

                    <div
                      class="mt-4"
                      v-else-if="props.application_forms.applicationF"
                    >
                      <label
                        for="applicationF"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >
                      <label>
                        <input
                          id="applicationF"
                          name="applicationF"
                          type="file"
                          accept=".pdf"
                          @change="
                            (event) => handleFileChange(event, 'applicationF')
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.applicationF"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.applicationF }}
                      </div>
                    </div>
                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.applicationF
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
                      v-else-if="props.application_forms.applicationF"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="
                            getFileUrl(props.application_forms.applicationF)
                          "
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("applicationF") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('applicationF')"
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
                      <span
                        v-if="
                          !form.applicationF &&
                          !getDisplayFileName('applicationF')
                        "
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>

              <div>
                <Card>
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
                        !props.application_forms.medical
                      "
                    >
                      <label
                        for="medical"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="medical"
                          name="medical"
                          type="file"
                          accept=".pdf"
                          @input="
                            (event) => (form.medical = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.medical"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.medical }}
                      </div>
                    </div>

                    <div
                      class="mt-4"
                      v-else-if="props.application_forms.medical"
                    >
                      <label
                        for="medical"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >
                      <label>
                        <input
                          id="medical"
                          name="medical"
                          type="file"
                          accept=".pdf"
                          @change="
                            (event) => handleFileChange(event, 'medical')
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.medical"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.medical }}
                      </div>
                    </div>

                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.medical
                      "
                    >
                      <div class="flex items-center justify-between">
                        <span
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{
                            form.medical
                              ? form.medical.name
                              : "No file selected"
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
                      v-else-if="props.application_forms.medical"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.medical)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("medical") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('medical')"
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
                      <span
                        v-if="!form.medical && !getDisplayFileName('medical')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>

              <div>
                <Card>
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
                        !props.application_forms.parent
                      "
                    >
                      <label
                        for="parent"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="parent"
                          name="parent"
                          type="file"
                          accept=".pdf"
                          @input="
                            (event) => (form.parent = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>

                      <br />
                      <div
                        v-if="localErrors.parent"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.parent }}
                      </div>
                    </div>

                    <div
                      class="mt-4"
                      v-else-if="props.application_forms.parent"
                    >
                      <label
                        for="parent"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >
                      <label>
                        <input
                          id="parent"
                          name="parent"
                          type="file"
                          accept=".pdf"
                          @change="(event) => handleFileChange(event, 'parent')"
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.parent"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.parent }}
                      </div>
                    </div>
                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.parent
                      "
                    >
                      <div class="flex items-center justify-between">
                        <span
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{
                            form.parent ? form.parent.name : "No file selected"
                          }}
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
                      v-else-if="props.application_forms.parent"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.parent)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("parent") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('parent')"
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
                      <span
                        v-if="!form.parent && !getDisplayFileName('parent')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>

              <div>
                <Card>
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
                        !props.application_forms.twobytwo
                      "
                    >
                      <label
                        for="twobytwo"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Upload File</label
                      >
                      <label>
                        <input
                          id="twobytwo"
                          name="twobytwo"
                          type="file"
                          accept=".jpg,.jpeg,.png"
                          @input="
                            (event) => (form.twobytwo = event.target.files[0])
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <br />
                      <div
                        v-if="localErrors.twobytwo"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.twobytwo }}
                      </div>
                    </div>

                    <div
                      class="mt-4"
                      v-else-if="props.application_forms.twobytwo"
                    >
                      <label
                        for="twobytwo"
                        class="py-3 px-7 rounded-full border-0 bg-blue text-md text-white transition-all duration-300 ease-in-out transform hover:bg-yellow-400 cursor-pointer"
                      >
                        <font-awesome-icon
                          :icon="['fas', 'file-upload']"
                          class="px-2 fa-lg"
                        />
                        Change File</label
                      >

                      <label>
                        <input
                          id="twobytwo"
                          name="twobytwo"
                          type="file"
                          accept=".jpg,.jpeg,.png"
                          @change="
                            (event) => handleFileChange(event, 'twobytwo')
                          "
                          class="text-sm text-grey-500 file:mr-5 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:cursor-pointer hover:file:bg-amber-50 hover:file:text-amber-700 sr-only"
                        />
                      </label>
                      <div
                        v-if="localErrors.twobytwo"
                        class="text-red-500 text-sm mt-5"
                      >
                        {{ localErrors.twobytwo }}
                      </div>
                    </div>

                    <div
                      class="rounded-md bg-[#F5F7FB] py-4 px-6 my-6"
                      v-if="
                        !props.application_forms ||
                        props.application_forms.length === 0 ||
                        !props.application_forms.twobytwo
                      "
                    >
                      <div class="flex items-center justify-between">
                        <span
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{
                            form.twobytwo
                              ? form.twobytwo.name
                              : "No file selected"
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
                      v-else-if="props.application_forms.twobytwo"
                    >
                      <div class="flex items-center justify-between">
                        <a
                          :href="getFileUrl(props.application_forms.twobytwo)"
                          class="truncate pr-3 text-base font-medium text-[#07074D]"
                        >
                          {{ getDisplayFileName("twobytwo") }}
                        </a>
                        <button
                          type="button"
                          class="text-[#07074D]"
                          @click="deleteIntern('twobytwo')"
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
                      <span
                        v-if="!form.twobytwo && !getDisplayFileName('twobytwo')"
                        class="truncate pr-3 text-base font-medium text-[#07074D]"
                      >
                        No file selected
                      </span>
                    </div>
                  </div>
                </Card>
              </div>
            </div>
          </div>
        </form>
        
      </div>
    </UserLayout>
  </div>
</template>