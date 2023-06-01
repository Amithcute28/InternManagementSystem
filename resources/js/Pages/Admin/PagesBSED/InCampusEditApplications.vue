<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
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
  <AdminLayout>
    <Head title="Create student" />

    <div class="max-w-7xl mx-auto py-4 mt-16">
      <div class="flex justify-between">
        <Link
          :href="route('applications.inCampusApplication')"
          class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
          >Back</Link>
      </div>
      <h1>AMITH</h1>
    </div>
  </AdminLayout>
</template>
