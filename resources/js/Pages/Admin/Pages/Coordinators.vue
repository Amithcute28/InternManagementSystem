<template>
  <div>
    <h1>User Profile</h1>

    <div v-if="success">{{ success }}</div>

    <div v-if="errors.length">
      <ul>
        <li v-for="error in errors" :key="error">{{ error }}</li>
      </ul>
    </div>

    <form @submit.prevent="uploadProfileImage">
      <input type="file" ref="profileImageInput" @change="onProfileImageChange" />
      <button type="submit">Upload</button>
    </form>

    <div v-if="profileImageURL">
      <img :src="profileImageURL" alt="Profile Image" />
      <form @submit.prevent="updateProfileImage">
        <input type="file" ref="profileImageInput" @change="onProfileImageChange" />
        <button type="submit">Update</button>
      </form>
      <form @submit.prevent="deleteProfileImage">
        <button type="submit">Delete</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { reactive } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';

const page = usePage();
const { data, post, put, delete: destroy } = useForm({
  profileImage: null,
  success: page.props.success || '',
  errors: page.props.errors || [],
  profileImageURL: page.props.user?.profile_image
});

const onProfileImageChange = (event) => {
  data.profileImage = event.target.files[0];
};

const uploadProfileImage = async () => {
  const formData = new FormData();
  formData.append('profile_image', data.profileImage);

  await post(route('profile.upload'), formData, {
    onSuccess: (response) => {
      data.success = response.success;
      data.errors = [];
      data.profileImage = null;
      data.profileImageURL = response.user.profile_image;
    },
    onError: (error) => {
      data.errors = Object.values(error.response.data.errors).flat();
    }
  });
};

const updateProfileImage = async () => {
  const formData = new FormData();
  formData.append('profile_image', data.profileImage);

  await put(route('profile.update'), formData, {
    onSuccess: (response) => {
      data.success = response.success;
      data.errors = [];
      data.profileImage = null;
      data.profileImageURL = response.user.profile_image;
    },
    onError: (error) => {
      data.errors = Object.values(error.response.data.errors).flat();
    }
  });
};

const deleteProfileImage = async () => {
  await destroy(route('profile.delete'), {
    onSuccess: () => {
      data.success = 'Profile image deleted successfully.';
      data.errors = [];
      data.profileImageURL = null;
    },
    onError: (error) => {
      data.errors = Object.values(error.response.data.errors).flat();
    }
  });
};
</script>