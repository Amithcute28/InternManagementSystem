<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import {ref} from "vue";
import ReqTabs from "@/Components/Tabs/ReqTabs.vue";

import GenericButton from "@/Components/GenericButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";
import Card from "@/Components/Card.vue";
import CheckIcon from "@/Components/Icons/CheckIcon.vue";
import XIcon from "@/Components/Icons/XIcon.vue";
import DescriptionList from "@/Components/DescriptionList.vue";
import DT from "@/Components/DT.vue";
import DD from "@/Components/DD.vue";
import DescriptionListItem from "@/Components/DescriptionListItem.vue";
import {__} from "@/Composables/useTranslations.js";
import {request_types} from "@/Composables/useRequestTypes.js";


const props = defineProps({
    request: Object,
})
const message = ref("");
const form = useForm({
    status: '',
    admin_response: '',
});

const submit = async () => {
    const isConfirmed = await Swal.fire({
        title: `Are you sure you want to ${message.value} this request?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
    });

    if (isConfirmed.value) {
        const rejectionReason =
            message.value === 'reject'
                ? await Swal.fire({
                      title: '(Optional) Provide a reason for rejecting this request:',
                      input: 'text',
                      inputPlaceholder: 'Reason...',
                      showCancelButton: true,
                  })
                : '';


        form.admin_response = rejectionReason.value || '';
        form.put(route('requests-update.update', { id: props.request.id }), {
            preserveScroll: true,
            onError: () => {
                Swal.fire('Error Updating Request Status', '', 'error');
            },
            onSuccess: () => {
                Swal.fire('Request Status Updated Successfully', '', 'success');
            },
        });
    }
};




const destroy = async () => {
    const confirmed = window.confirm("Are you sure? You won't be able to revert this!");

    if (confirmed) {
        await form.delete(route('requests.destroy', { id: props.request.id }), {
            preserveScroll: true,
            onError: () => {
                alert('Error Deleting Request');
            },
            onSuccess: () => {
                alert('Request Removed!', '', 'success');
            },
        });
    }
};




</script>

<template>
    <Head :title="('Request Data')"/>
    <AdminLayout>
        <template #tabs>
            <ReqTabs />
        </template>
        <div class="py-8 mt-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <h1 class="card-header mb-2">{{('Request #:id Data', {id: request.id})}}</h1>
                            <div class="flex inline-flex gap-4">
                                <form @submit.prevent="submit"  class="flex gap-4">
                                    <GenericButton v-if="request.status !== 'Approved'" :text="('Approve Request')"
                                                   @click="form.status = 1; message=('approve');"
                                                   :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        <CheckIcon/>
                                    </GenericButton>
                                    <GenericButton v-if="request.status !== 'Rejected'" :text="('Reject Request')"
                                                   @click="form.status = 2; message= ('reject');"
                                                   :class="{ 'opacity-25': form.processing }"
                                                   :disabled="form.processing">
                                        <XIcon/>
                                    </GenericButton>
                                </form>
                            </div>
                        </div>

                        <h2 class="mb-2 ml-1 font-semibold">{{('Request Info')}}</h2>

                        <DescriptionList>
                            <DescriptionListItem colored>
                                <DT>{{('ID')}}</DT>
                                <DD>{{ request.id }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{('Created By')}}</DT>
                                <DD>{{ request.full_name }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem>
                                <DT>{{('Request Type')}}</DT>
                                <DD>{{ request_types[request.type] }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem>
                                <DT>{{('Request Message')}}</DT>
                                <DD>{{ request.message }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{('From Date')}}</DT>
                                <DD>{{ request.start_date }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{('To Date')}}</DT>
                                <DD>{{ request.end_date ?? ('N/A') }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem>
                                <DT>{{('Submission Date')}}</DT>
                                <DD>{{ (new Date(props.request.created_at)).toISOString().split("T")[0] }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem>
                                <DT>{{('Status')}}</DT>
                                <DD>{{
                                        request.status === "Pending" ? ('Pending') + ' ⏳':
                                        request.status === "Approved" ? ('Approved') + ' ✅' :
                                        ('Rejected') + ' 🚫'
                                    }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT>{{('Admin Response')}}</DT>
                                <DD>{{ request.admin_response ?? '-' }}</DD>
                            </DescriptionListItem>

                            <DescriptionListItem colored>
                                <DT></DT><DD></DD>
                            </DescriptionListItem>
                        </DescriptionList>

                        <form  @submit.prevent="destroy" class="flex justify-end">
                            <PrimaryButton class="bg-red-600 hover:bg-red-700 ml-4 mt-4 focus:bg-red-500 active:bg-red-900" >
                                {{('Delete Request')}}
                            </PrimaryButton>
                        </form>
                    </div>
                </Card>
            </div>
        </div>
    </AdminLayout>
</template>
