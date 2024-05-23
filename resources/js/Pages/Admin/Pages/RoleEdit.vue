<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';


const props = defineProps({
    role: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: props.role.name
})
</script>

<template>
    <Head title="Edit role" />

    <AdminLayout>
        <div class="max-w-7xl mx-auto py-4">
           <div class="flex justify-between">
            
            <Link :href="route('role.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Back</Link>
           </div>
            
           
            <div class="mt-6">
                <form @submit.prevent="form.put(route('role.update', role.id))" class="mt-6" action="#" method="POST">
        <div>
          <label class="block text-gray-700">Name</label>
          <input 
          type="text" 
          name="" 
          id="name" 
          v-model="form.name"
          placeholder="Enter name" 
          class="text-xm max-w-md mx-auto px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none" 
          autofocus 
          required 
          autocomplete="username">
          <InputError class="mt-2" :message="form.errors.name" />
        </div>

       

        <div class="flex justify-end mt-4">
         
                <button type="submit" class="w-80 py-2.5 block bg-indigo-500 hover:bg-indigo-400 focus:bg-indigo-400 text-white font-semibold rounded-lg
              px-4 py-3 mt-6" :class=" {'opacity-25': form.processing }" :disabled="form.processing">Update</button>
        </div>
</form>
            </div>
        </div>
    </AdminLayout>

  
</template>
