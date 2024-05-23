<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import {Head, useForm, usePage} from '@inertiajs/vue3';

import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ReqTabs from "@/Components/Tabs/ReqTabs.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import '@vuepic/vue-datepicker/dist/main.css'
import dayjs from "dayjs";
import Card from "@/Components/Card.vue";
import {inject, watch} from "vue";
import {__} from "@/Composables/useTranslations.js";

defineProps({
    types: Array,
});

const form = useForm({
    type: '',
    date: '',
    message: '',
});

watch(() => form.type, (value) => {
    if (value === 'leave')
        form.date = '';
});

const submitForm = () => {
    Object.keys(form.date).forEach(function (key) {
        if (form.date[key] && !/^\d{4}-\d{2}-\d{2}$/.test(form.date[key])){
            form.date[key] = dayjs(form.date[key]).format('YYYY-MM-DD');
        }
    });

    console.log(form.date);

    form.post(route('requests.store'), {
        preserveScroll: true,
        onError: () => {
            if (usePage().props.errors.past_leave){
                alert(usePage().props.errors.past_leave);
            } else {
                alert('Error Creating Request');
            }
        },
        onSuccess: () => {
            alert('Request Created Successfully');
            form.reset();
        }
    });
};

</script>
<template>
    <Head :title="('Request Create')"/>
    <UserLayout>
        <template #tabs>
            <ReqTabs />
        </template>
        <div class="py-8 mt-10">
            <p class="text-2xl font-semibold ml-4 mb-6">Create a Request</p>
            
                <Card class="!mt-0">
                    <form @submit.prevent="submitForm">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="type_id" :value="('Type')"/>
                                <select id="manager_id" class="fancy-selector" v-model="form.type">
                                    <option selected value="">{{('Choose a Request Type')}}</option>
                                    <option v-for="type in types" :key="type.id" :value="type">
                                        {{ type }}
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
                                    :placeholder="('Select Date...')"
                                    :enable-time-picker="false"
                                     :min-date="new Date()"
                                    :dark="inject('isDark')"
                                    range
                                    required
                                ></VueDatePicker>
                                
                                <InputError class="mt-2" :message="form.errors.date"/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4 mt-4">
                            <div>
                                <InputLabel for="message" :value="('Message')"/>
                                <TextInput
                                    id="message"
                                    type="text"
                                    class="mt-1 block w-full"
                                    :class="{'border border-red-500': form.errors.message}"
                                    v-model="form.message"
                                    autocomplete="off"
                                    :placeholder="('I will be absent for 3 days because I\'m sick.')"
                                />
                                <InputError class="mt-2" :message="form.errors.message"/>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ltr:ml-4 rtl:mr-4" :class="{ 'opacity-25': form.processing }"
                                           :disabled="form.processing">
                                {{('Initiate Request')}}
                            </PrimaryButton>
                        </div>
                    </form>
                </Card>

            
        </div>
    </UserLayout>
</template>
