<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link, useForm } from "@inertiajs/vue3";
import ModalDialog from "@/Components/ModalDialog.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Arrow from "@/Components/Arrow.vue";
import ReusableCard from "@/Components/ReusableCard.vue";
import { ref } from "vue";

const props = defineProps({
  schools: Array,
});

const modalActive = ref(null);
const toggleModal = () => {
  modalActive.value = !modalActive.value;
};

const form = useForm({
  schoolName: "",
  schoolAddress: "",
  schoolLogo: null,
});

const submit = () => {
  let formData = new FormData();
  formData.append("schoolName", form.schoolName);
  formData.append("schoolAddress", form.schoolAddress);
  formData.append("schoolLogo", form.schoolLogo);

  form.post(route("schools.store"), formData, {
    onFinish: () => form.reset("schoolName", "schoolAddress", "schoolLogo"),
  });
};
</script>

<template>
  <Head title="Status" />

  <UserLayout>
    <div class="h-full mt-16">
      <div>
        <!-- <Link :href="route('schools.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded" @click="toggleModal" @close-modal="toggleModal">Add New School</Link> -->
        <Link
          :href="route('status.index')"
          class="px-3 py-2 text-white font-semibold bg-blue-700 hover:bg-blue-900 rounded m-4"
          >Back</Link
        >
      </div>
      <div class="grid grid-cols-2 gap-0">
        <div
          class="col-span-12 sm:col-span-12 md:col-span-12 lg:col-span-8 xxl:col-span-8 px-6 py-6"
        >
          <div class="grid grid-cols-12 gap-6">
            <ReusableCard>
              <img
                src="@/Assets/images (3).jpg"
                class="w-auto h-24 rounded-lg"
              />
              <div>
                <p class="font-semibold text-base">
                  Leyte National High School
                </p>
                <p class="font-semibold text-sm text-gray-400">Tacloban City</p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ReusableCard>
              <img
                src="@/Assets/images (4).jpg"
                class="w-auto h-24 rounded-lg"
              />
              <div>
                <p class="font-semibold text-base">
                  Pawing National High School
                </p>
                <p class="font-semibold text-sm text-gray-400">Palo, Leyte</p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ReusableCard>
              <img src="@/Assets/sanjose.jpg" class="w-auto h-24 rounded-lg" />
              <div>
                <p class="font-semibold text-base">
                  San Jose National High School
                </p>
                <p class="font-semibold text-sm text-gray-400">Tacloban City</p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ReusableCard>
              <img
                src="@/Assets/images (6).jpg"
                class="w-auto h-24 rounded-lg"
              />
              <div>
                <p class="font-semibold text-base">Sagkahan Central School</p>
                <p class="font-semibold text-sm text-gray-400">Palo, Leyte</p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ReusableCard>
              <img
                src="@/Assets/images (5).jpg"
                class="w-auto h-24 rounded-lg"
              />
              <div>
                <p class="font-semibold text-base">
                  AMA Computer Learning Center
                </p>
                <p class="font-semibold text-sm text-gray-400">Tacloban City</p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ReusableCard>
              <img src="@/Assets/OIP.jpg" class="w-auto h-24 rounded-lg" />
              <div>
                <p class="font-semibold text-base">
                  Quinapondan National High School
                </p>
                <p class="font-semibold text-sm text-gray-400">
                  Quinapondan, Eastern Samar
                </p>
                <PrimaryButton @click="toggleModal"
                  ><template #icon> <Arrow></Arrow> </template> Choose
                </PrimaryButton>
              </div>
            </ReusableCard>
            <ModalDialog :modalActive="modalActive" @close-modal="toggleModal">
              <div class="">
                <div class="w-full text-white bg-main-color mt-16">
                  <div
                    x-data="{ open: false }"
                    class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8"
                  ></div>
                </div>
                <!-- End of Navbar -->

                <!-- Profile tab -->
                <!-- About Section -->

                <!-- End of about section -->

                <!-- <form
      class="py-2 "
      @submit.prevent="submit"
      action="https://formbold.com/s/FORM_ID"
      method="POST"
    >
      <div class="grid grid-cols-2 gap-5">
  <div class="col-span-1 mb-5">
    <label for="school_name" class="mb-3 block text-base font-medium text-[#07074D]">
      School Name:
    </label>
    <input type="text" v-model="form.school_name" name="school_name" id="school_name" placeholder="Name of the School" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
  <div class="col-span-1 mb-5">
    <label for="school_address" class="mb-3 block text-base font-medium text-[#07074D]">
      School Address:
    </label>
    <input type="text" v-model="form.school_address" name="school_address" id="school_address" placeholder="Address of the school" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
  </div>
</div>

      <div class="mb-6 pt-4">
        <label class="mb-5 block text-xl font-semibold text-[#07074D]">
          Upload Logo
        </label>

        <div class="mb-8">
          <input type="file"  @input="form.school_logo = $event.target.files[0]" name="school_logo" id="school_logo" class="sr-only" />
          <label
            for="school_logo"
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

        <div class="mb-5 rounded-md bg-[#F5F7FB] py-4 px-8" v-if="form.schoolLogo">
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
         type="submit" class="hover:shadow-form w-full rounded-md bg-[#6A64F1] py-3 px-8 text-center text-base font-semibold text-white outline-none"
        >
          Add School
        </button>
      </div>
    </form> -->

                <div class="container my-4 px-6 mx-auto">
                  <!-- Section: Design Block -->
                  <section class="mb-32 text-gray-800">
                    <div class="block rounded-lg shadow-lg bg-white">
                      <div class="flex flex-wrap items-center">
                        <div
                          class="grow-0 shrink-0 basis-auto block w-full lg:flex lg:w-6/12 xl:w-4/12"
                        >
                          <div class="map-container-2 w-full">
                            <iframe
                              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1956.657715528662!2d125.00004053842936!3d11.238190528016471!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3308772c87c4c367%3A0xa5e5c080ec6a88ef!2sLeyte%20Normal%20University!5e0!3m2!1sen!2sph!4v1683656352509!5m2!1sen!2sph"
                              class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg"
                              frameborder="0"
                              allowfullscreen
                            ></iframe>
                          </div>
                        </div>
                        <div
                          class="grow-0 shrink-0 basis-auto w-full lg:w-6/12 xl:w-8/12"
                        >
                          <div
                            class="bg-white p-3 flex items-center justify-between ml-6 mt-4 mb-4"
                          >
                            <div class="flex space-x-6 items-center">
                              <img
                                src="@/Assets/images (3).jpg"
                                class="w-auto h-24 rounded-lg"
                              />
                              <div>
                                <p class="font-semibold text-2xl">
                                  Leyte National High School
                                </p>
                                <p class="font-semibold text-lg text-gray-400">
                                  Tacloban City
                                </p>
                              </div>
                            </div>
                          </div>
                          <div class="flex flex-wrap pt-12 lg:pt-0">
                            <div
                              class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12"
                            >
                              <div class="flex items-start">
                                <div class="shrink-0">
                                  <div
                                    class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center"
                                  >
                                    <svg
                                      aria-hidden="true"
                                      focusable="false"
                                      data-prefix="fas"
                                      data-icon="headset"
                                      class="w-5 text-white"
                                      role="img"
                                      xmlns="http://www.w3.org/2000/svg"
                                      viewBox="0 0 512 512"
                                    >
                                      <path
                                        fill="currentColor"
                                        d="M192 208c0-17.67-14.33-32-32-32h-16c-35.35 0-64 28.65-64 64v48c0 35.35 28.65 64 64 64h16c17.67 0 32-14.33 32-32V208zm176 144c35.35 0 64-28.65 64-64v-48c0-35.35-28.65-64-64-64h-16c-17.67 0-32 14.33-32 32v112c0 17.67 14.33 32 32 32h16zM256 0C113.18 0 4.58 118.83 0 256v16c0 8.84 7.16 16 16 16h16c8.84 0 16-7.16 16-16v-16c0-114.69 93.31-208 208-208s208 93.31 208 208h-.12c.08 2.43.12 165.72.12 165.72 0 23.35-18.93 42.28-42.28 42.28H320c0-26.51-21.49-48-48-48h-32c-26.51 0-48 21.49-48 48s21.49 48 48 48h181.72c49.86 0 90.28-40.42 90.28-90.28V256C507.42 118.83 398.82 0 256 0z"
                                      ></path>
                                    </svg>
                                  </div>
                                </div>

                                <div class="grow ml-6">
                                  <p class="font-bold mb-1">School Info</p>
                                  <p class="text-gray-500">
                                    support@example.com
                                  </p>
                                  <p class="text-gray-500">+1 234-567-89</p>
                                </div>
                              </div>
                            </div>
                            <div
                              class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12"
                            >
                              <div class="flex items-start">
                                <div class="shrink-0">
                                  <div
                                    class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center"
                                  >
                                    <svg
                                      aria-hidden="true"
                                      focusable="false"
                                      data-prefix="fas"
                                      data-icon="dollar-sign"
                                      class="w-3 text-white"
                                      role="img"
                                      xmlns="http://www.w3.org/2000/svg"
                                      viewBox="0 0 288 512"
                                    >
                                      <path
                                        fill="currentColor"
                                        d="M209.2 233.4l-108-31.6C88.7 198.2 80 186.5 80 173.5c0-16.3 13.2-29.5 29.5-29.5h66.3c12.2 0 24.2 3.7 34.2 10.5 6.1 4.1 14.3 3.1 19.5-2l34.8-34c7.1-6.9 6.1-18.4-1.8-24.5C238 74.8 207.4 64.1 176 64V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48h-2.5C45.8 64-5.4 118.7.5 183.6c4.2 46.1 39.4 83.6 83.8 96.6l102.5 30c12.5 3.7 21.2 15.3 21.2 28.3 0 16.3-13.2 29.5-29.5 29.5h-66.3C100 368 88 364.3 78 357.5c-6.1-4.1-14.3-3.1-19.5 2l-34.8 34c-7.1 6.9-6.1 18.4 1.8 24.5 24.5 19.2 55.1 29.9 86.5 30v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16v-48.2c46.6-.9 90.3-28.6 105.7-72.7 21.5-61.6-14.6-124.8-72.5-141.7z"
                                      ></path>
                                    </svg>
                                  </div>
                                </div>
                                <div class="grow ml-6">
                                  <p class="font-bold mb-1">School Info</p>
                                  <p class="text-gray-500">sales@example.com</p>
                                  <p class="text-gray-500">+1 234-567-89</p>
                                </div>
                              </div>
                            </div>
                            <div
                              class="mb-12 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12"
                            >
                              <div class="flex align-start">
                                <div class="shrink-0">
                                  <div
                                    class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center"
                                  >
                                    <svg
                                      aria-hidden="true"
                                      focusable="false"
                                      data-prefix="fas"
                                      data-icon="newspaper"
                                      class="w-5 text-white"
                                      role="img"
                                      xmlns="http://www.w3.org/2000/svg"
                                      viewBox="0 0 576 512"
                                    >
                                      <path
                                        fill="currentColor"
                                        d="M552 64H88c-13.255 0-24 10.745-24 24v8H24c-13.255 0-24 10.745-24 24v272c0 30.928 25.072 56 56 56h472c26.51 0 48-21.49 48-48V88c0-13.255-10.745-24-24-24zM56 400a8 8 0 0 1-8-8V144h16v248a8 8 0 0 1-8 8zm236-16H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm-208-96H140c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm208 0H348c-6.627 0-12-5.373-12-12v-8c0-6.627 5.373-12 12-12h152c6.627 0 12 5.373 12 12v8c0 6.627-5.373 12-12 12zm0-96H140c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h360c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12z"
                                      ></path>
                                    </svg>
                                  </div>
                                </div>
                                <div class="grow ml-6">
                                  <p class="font-bold mb-1">School Info</p>
                                  <p class="text-gray-500">press@example.com</p>
                                  <p class="text-gray-500">+1 234-567-89</p>
                                </div>
                              </div>
                            </div>
                            <div
                              class="mb-12 lg:mb-0 grow-0 shrink-0 basis-auto w-full md:w-6/12 lg:w-full xl:w-6/12 px-3 md:px-6 xl:px-12"
                            >
                              <div class="flex align-start">
                                <div class="shrink-0">
                                  <div
                                    class="p-4 bg-blue-600 rounded-md shadow-md w-14 h-14 flex items-center justify-center"
                                  >
                                    <svg
                                      aria-hidden="true"
                                      focusable="false"
                                      data-prefix="fas"
                                      data-icon="bug"
                                      class="w-5 text-white"
                                      role="img"
                                      xmlns="http://www.w3.org/2000/svg"
                                      viewBox="0 0 512 512"
                                    >
                                      <path
                                        fill="currentColor"
                                        d="M511.988 288.9c-.478 17.43-15.217 31.1-32.653 31.1H424v16c0 21.864-4.882 42.584-13.6 61.145l60.228 60.228c12.496 12.497 12.496 32.758 0 45.255-12.498 12.497-32.759 12.496-45.256 0l-54.736-54.736C345.886 467.965 314.351 480 280 480V236c0-6.627-5.373-12-12-12h-24c-6.627 0-12 5.373-12 12v244c-34.351 0-65.886-12.035-90.636-32.108l-54.736 54.736c-12.498 12.497-32.759 12.496-45.256 0-12.496-12.497-12.496-32.758 0-45.255l60.228-60.228C92.882 378.584 88 357.864 88 336v-16H32.666C15.23 320 .491 306.33.013 288.9-.484 270.816 14.028 256 32 256h56v-58.745l-46.628-46.628c-12.496-12.497-12.496-32.758 0-45.255 12.498-12.497 32.758-12.497 45.256 0L141.255 160h229.489l54.627-54.627c12.498-12.497 32.758-12.497 45.256 0 12.496 12.497 12.496 32.758 0 45.255L424 197.255V256h56c17.972 0 32.484 14.816 31.988 32.9zM257 0c-61.856 0-112 50.144-112 112h224C369 50.144 318.856 0 257 0z"
                                      ></path>
                                    </svg>
                                  </div>
                                </div>
                                <div class="grow ml-6">
                                  <p class="font-bold mb-1">School Info</p>
                                  <p class="text-gray-500">bugs@example.com</p>
                                  <p class="text-gray-500">+1 234-567-89</p>
                                </div>
                              </div>
                            </div>
                            <Link
                              class="flex justify-center block w-full text-white text-sm font-semibold rounded-lg bg-indigo-500 hover:bg-indigo-400 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs py-3 my-4 ml-6"
                              >Edit Information</Link
                            >
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>
                  <!-- Section: Design Block -->
                </div>
                <!-- Experience and education -->

                <!-- End of profile tab -->
              </div>
            </ModalDialog>

            <!-- <div class="col-span-12 sm:col-span-12 md:col-span-6 lg:col-span-6 xxl:col-span-6">
                        
                        <div class="bg-white p-3 rounded-xl shadow-xl flex items-center justify-between mt-4">
                    <div class="flex space-x-6 items-center">
                        <img src="@/Assets/logo.png" class="w-auto h-24 rounded-lg"/>
                        <div>
                            <p class="font-semibold text-base">Leyte Normal University</p>
                            <p class="font-semibold text-sm text-gray-400">A leading university of education and diverse disciplines attuned to local and global development ne</p>
                            <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5">
            Read more
            <svg aria-hidden="true" class="w-4 h-4 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </a>
                        </div>              
                    </div>
                       
                    <div class="flex space-x-2 items-center">
                        <div class="bg-gray-300 rounded-md p-2 flex items-center">
                            <i class="fas fa-chevron-right fa-sm text-black"></i>
                        </div>
                    </div>    
                </div>
                      
                        
                    </div> -->
          </div>
        </div>
      </div>
    </div>
  </UserLayout>
</template>
