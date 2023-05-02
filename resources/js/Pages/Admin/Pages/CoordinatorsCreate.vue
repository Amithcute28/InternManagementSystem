<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
        student_id: '',
        full_name: '',
        email: '',
        gender: '',
        contact: '',
        current_address: '',
        permanent_address: '',
        birthday: '',
        password: '',
        password_confirmation: '',
        terms: false,
});

const submit = () => {
    form.post(route('coordinators.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

 <template>
<AdminLayout>
        <Head title="Create student" />



 

  <div class="max-w-7xl mx-auto py-4">
    <div class="flex justify-between">
                
            <Link :href="route('coordinators.index')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">Back</Link>
           </div>
    <div class="w-80 h-100">



      <form @submit.prevent="submit" class="mt-6" action="#" method="POST">
            <div>
                <InputLabel for="student_id" value="ID" />
    
                <TextInput
                    id="student_id"
                    type="id"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="Name"
                    v-model="form.student_id"
                    required
                    autofocus
                    autocomplete="student_id"
                />
    
                <InputError class="mt-2" :message="form.errors.student_id" />
            </div>
    
            <div>
                <InputLabel for="full_name" value="Name" />
    
                <TextInput
                    id="full_name"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="Name"
                    v-model="form.full_name"
                    required
                    autofocus
                    autocomplete="full_name"
                />
    
                <InputError class="mt-2" :message="form.errors.full_name" />
            </div>
    
            <div class="mt-4">
                <InputLabel for="email" value="Email" />
    
                <TextInput
                    id="email"
                    type="email"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="Email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
    
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
    
         <div>
                <InputLabel for="gender" value="Gender" />
    
                <TextInput
                    id="gender"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="gender"
                    v-model="form.gender"
                    required
                    autofocus
                    autocomplete="gender"
                />
    
                <InputError class="mt-2" :message="form.errors.gender" />
            </div>
    
            <div>
                <InputLabel for="contact" value="Contact No" />
    
                <TextInput
                    id="contact"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="number"
                    v-model="form.contact"
                    required
                    autofocus
                    autocomplete="contact"
                />
    
                <InputError class="mt-2" :message="form.errors.contact" />
            </div>
    
           
    
            <div>
                <InputLabel for="current_address" value="Currenr Address" />
    
                <TextInput
                    id="current_address"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="current_address"
                    v-model="form.current_address"
                    required
                    autofocus
                    autocomplete="current_address"
                />
    
                <InputError class="mt-2" :message="form.errors.current_address" />
            </div>
    
            <div>
                <InputLabel for="permanent_address" value="Permanent Address" />
    
                <TextInput
                    id="permanent_address"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="permanent_address"
                    v-model="form.permanent_address"
                    required
                    autofocus
                    autocomplete="permanent_address"
                />
    
                <InputError class="mt-2" :message="form.errors.permanent_address" />
            </div>
    
            <div>
                <InputLabel for="birthday" value="Birthday" />
    
                <TextInput
                    id="birthday"
                    type="text"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="birthday"
                    v-model="form.birthday"
                    required
                    autofocus
                    autocomplete="birthday"
                />
    
                <InputError class="mt-2" :message="form.errors.birthday" />
            </div>
    
            <div class="mt-4">
                <InputLabel for="password" value="Password" />
    
                <TextInput
                    id="password"
                    type="password"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
    
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
    
            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
    
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="text-xm w-80 px-4 py-2.5 rounded-lg mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                    placeholder="Confirm password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    
                />
    
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>
    
            
                <button type="submit" class="w-80 py-2.5 block bg-indigo-500 hover:bg-indigo-400 focus:bg-indigo-400 text-white font-semibold rounded-lg
                  px-4 py-3 mt-6">Register</button>
    
        </form>


    


    </div>
  </div>


        
    </AdminLayout>
</template>