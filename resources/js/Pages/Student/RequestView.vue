<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
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

const submit = () => {
    const isConfirmed = window.confirm(`Are you sure you want to ${message.value} this request?`);

    if (isConfirmed) {
        const rejectionReason = message.value === 'reject' ? window.prompt('(Optional) Provide a reason for rejecting this request:') : '';

       
        form.admin_response = rejectionReason || '';
        form.put(route('requests-update.update', { id: props.request.id }), {
            preserveScroll: true,
            onError: () => {
                alert('Error Updating Request Status');
            },
            onSuccess: () => {
                alert('Request Status Updated Successfully');
            }
        });
    }
};




const destroy = () => {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'mx-4 text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900',
            cancelButton: 'text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900'
        },
        buttonsStyling: false
    })
    swalWithBootstrapButtons.fire({
        title: ('Are you sure?'),
        text: ('You won\'t be able to revert this!'),
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: ('Yes, Delete!'),
        cancelButtonText: ('No, Cancel!'),
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('requests.destroy', {id: props.request.id}), {
                preserveScroll: true,
                onError: () => {
                    useToast().error(('Error Deleting Request'));
                },
                onSuccess: () => {
                    Swal.fire(('Request Removed!'), '', 'success')
                }
            });
        }
    })
};

</script>

<template>
    <Head :title="('Request Data')"/>
    <UserLayout>
        <template #tabs>
            <ReqTabs />
        </template>
        <div class="py-8 mt-10">
            <h1>Student</h1>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Card class="!mt-0">
                    <div>

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

                      
                    </div>
                </Card>
            </div>
        </div>
    </UserLayout>
</template>
