<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
// import {useToast} from "vue-toastification";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import CalendarTabs from "@/Components/Tabs/CalendarTabs.vue";
import Notice from "@/Components/Notice.vue";
import Card from "@/Components/Card.vue";
import {inject} from "vue";
import {__} from "@/Composables/useTranslations.js";
import {calendar_types} from "@/Composables/useCalendarItemTypes.js";
import dayjs from "dayjs";

const props = defineProps({
    types: Array,
});

const form = useForm({
    date: '',
    title: '',
    type: '',
});


const submitForm = () => {
    Object.keys(form.date).forEach(function (key) {
        if (form.date[key] && !/^\d{4}-\d{2}-\d{2}$/.test(form.date[key])){
            form.date[key] = dayjs(form.date[key]).format('YYYY-MM-DD');
        }
    });
    form.post(route('calendar.store'), {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head :title="('Calendar Item Creation')"/>
    <AdminLayout>
        <template #tabs>
            <CalendarTabs/>
        </template>
        <div class="py-8 mt-10">
            <p class="text-2xl font-semibold ml-4 mb-6">Calendar Items</p>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
               
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="type_id" :value="('Type')"/>
                                <select id="manager_id" class="fancy-selector" v-model="form.type">
                                    <option selected value="">{{('Choose a Request Type')}}</option>
                                    <option v-for="type in types" :key="type.id" :value="type">
                                        {{ calendar_types[type] }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.type"/>
                            </div>
                            <div>
                                <InputLabel for="date" :value="('Date (Range selection is available)')"/>
                                <VueDatePicker
                                    id="date"
                                    v-model="form.date"
                                    class="py-1 block w-full"
                                    :class="{'border border-red-500': form.errors.date}"
                                    :placeholder="('Select a Date..')"
                                    :enable-time-picker="false"
                                    :dark="inject('isDark')"
                                    range
                                    required
                                ></VueDatePicker>
                                <InputError class="mt-2" :message="form.errors.date"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="title" :value="('Title')"/>
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :class="{'border border-red-500': form.errors.title}"
                                    v-model="form.title"
                                    autocomplete="off"
                                    :placeholder="('I will be absent for 3 days because I\'m sick.')"
                                />
                                <InputError class="mt-2" :message="form.errors.title"/>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ltr:ml-4 rtl:mr-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing"
                            >
                                {{('Initiate Request')}}
                            </PrimaryButton>
                        </div>
                    </form>
               

            </div>
        </div>
    </AdminLayout>
</template>
