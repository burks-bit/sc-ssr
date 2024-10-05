<script setup>
import { computed, ref, toRefs } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const emit = defineEmits(['close', 'save']);
const props = defineProps({
    members: Object,
    barangays: Object,
    userRole: String
});

const { userRole: userRoleRef } = toRefs(props);

const role = userRoleRef.value
console.log(role)
// console.log(toRefs(props.barangays));
const barangays = toRefs(props.barangays);
const isVisible = ref(false);
const message = ref('');
const notificationType = ref('');

// Create a form to handle member enrollment
const memberForm = useForm({
    first_name: '',
    middle_name: '',
    last_name: '',
    date_of_birth: '',
    gender: '',
    test_address: '',
    barangay: '',
    city: '',
    province: '',
    postal_code: '',
    phone_number: '',
    email: ''
});


// Function to submit the form
const enrollMember = () => {
    console.log(memberForm)
    memberForm.post(`/${role}/members/save`, {
        onSuccess: () => {
            // Handle success (e.g., show a notification, redirect, etc.)
            console.log('Member enrolled successfully!');
            showNotification('Member enrolled successfully!', 'success');
        },
        onError: (error) => {
            // Handle error (e.g., show an error notification)
            console.error('Error enrolling member:', error);
        }
    });
};

const showNotification = (msg, type) => {
    message.value = msg;
    notificationType.value = type;
    isVisible.value = true;

    setTimeout(() => {
        isVisible.value = false;
    }, 10000);
};

const notificationClass = computed(() => {
    return notificationType.value === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white';
});
</script>

<template>
    <Head title="Enroll New Member" />

    <AuthenticatedLayout headerTitle="Enroll New Member">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div v-if="$page.props.auth.user.role == 1">
                <Link 
                    :href="route('admin.members.list')" 
                    :active="route().current('members')"
                    class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <i class="fas fa-arrow-left ml-1"></i>&ensp;Back
                </Link>
            </div>
            <div v-else>
                <Link 
                    :href="route('moderator.members.list')" 
                    :active="route().current('moderator.members')"
                    class="inline-flex items-center px-2 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    <i class="fas fa-arrow-left ml-1"></i>&ensp;Back
                </Link>
            </div>

            <div class="p-4 sm:p-3 bg-white shadow sm:rounded-lg">
                <form @submit.prevent="enrollMember">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <input v-model="memberForm.first_name" type="text" placeholder="First Name" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <input v-model="memberForm.middle_name" type="text" placeholder="Middle Name" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <input v-model="memberForm.last_name" type="text" placeholder="Last Name & Ext" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <input v-model="memberForm.date_of_birth" type="date" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                        </div>

                        <div>
                            <select v-model="memberForm.gender" class="m-1 border border-gray-300 rounded-md w-full p-2" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                            <input v-model="memberForm.text_address" type="text" placeholder="House No. /Purok/Zone" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <select v-model="memberForm.barangay" class="m-1 border border-gray-300 rounded-md w-full p-2" required>
                                <option value="" disabled selected>Select Barangay</option>
                                <option v-for="(name, id) in barangays" :key="id" :value="id">{{ name }}</option>
                            </select>
                            <select v-model="memberForm.city" class="m-1 border border-gray-300 rounded-md w-full p-2" required>
                                <option value="" disabled selected>Select City/Municipality</option>
                                <option value="Polangui">Polangui</option>
                            </select>
                        </div>

                        <div>
                            <select v-model="memberForm.province" class="m-1 border border-gray-300 rounded-md w-full p-2" required>
                                <option value="" disabled selected>Select Province</option>
                                <option value="Albay">Albay</option>
                            </select>
                            <input v-model="memberForm.postal_code" type="text" placeholder="Postal Code" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <input v-model="memberForm.phone_number" type="text" placeholder="Phone Number" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                            <input v-model="memberForm.email" type="email" placeholder="Email" class="m-1 border border-gray-300 rounded-md w-full p-2" required />
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <button class="px-4 py-2 bg-green-600 text-white rounded-md">Enroll Member</button>
                    </div>
                </form>
            </div>

            <!-- Notification -->
            <div v-if="isVisible" :class="['fixed top-5 right-5 z-50 p-4 rounded shadow-md', notificationClass]">
               <p>{{ message }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
