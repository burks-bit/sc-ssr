<script setup>
import { ref, toRefs, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    scmembers: Object,
});

const emit = defineEmits(['close', 'save']);
const isModalOpen = ref(false);
const memberData = ref({});
const isVisible = ref(false);
const message = ref('');
const notificationType = ref('');

const openModal = (member) => {
    memberData.value = { ...member };
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const memberForm = useForm({
    id: null,
    first_name: null,
    last_name: null,
    date_of_birth: null, // Add all necessary fields here
    gender: null,
    address: null,
    city: null,
    state: null,
    postal_code: null,
    phone_number: null,
    email: null,
    emergency_contact_name: null,
    emergency_contact_phone: null,
    medical_conditions: null,
    medications: null,
    allergies: null,
});

const saveChanges = () => {
    // Prepare the data to be sent
    memberForm.id = memberData.value.id; // If you're updating
    memberForm.first_name = memberData.value.first_name;
    memberForm.last_name = memberData.value.last_name;
    memberForm.date_of_birth = memberData.value.date_of_birth; // Include additional fields
    memberForm.gender = memberData.value.gender;
    memberForm.address = memberData.value.address;
    memberForm.city = memberData.value.city;
    memberForm.state = memberData.value.state;
    memberForm.postal_code = memberData.value.postal_code;
    memberForm.phone_number = memberData.value.phone_number;
    memberForm.email = memberData.value.email;
    memberForm.emergency_contact_name = memberData.value.emergency_contact_name;
    memberForm.emergency_contact_phone = memberData.value.emergency_contact_phone;
    memberForm.medical_conditions = memberData.value.medical_conditions;
    memberForm.medications = memberData.value.medications;
    memberForm.allergies = memberData.value.allergies;

    memberForm.post('/admin/members/save', {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            showNotification('Changes saved successfully!', 'success');
        },
        onError: (error) => {
            console.error(error);
            showNotification('Error occurred. Please try again.', 'error');
        }
    });
};

const { scmembers } = toRefs(props);
const searchMemberForm = useForm({
    name: ''
});
const searchMember = () => {
    searchMemberForm.get('/admin/members/list', {
        preserveScroll: true,
        onSuccess: () => {
            showNotification('Not Found', 'success');
        },
        onError: (error) => {
            console.error('Error searching member:', error);
        }
    });
}

const selectedMember = ref(null);
const handleSelectRow = (member) => {
    selectedMember.value = member;
    console.log(selectedMember.value);
    if(selectedMember.value == ''){

    }
}

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
    <Head title="SC Members" />
    <AuthenticatedLayout headerTitle="Members">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Members</h2>
        </template> -->

        <!-- <div class="py-6"> -->
            <div class="max-w-7xl mx-auto sm:px-6 space-y-6">
                

                <table style="width: 100%;">
                    <tr>
                        <td>
                            <input type="text" v-model="searchMemberForm.name" placeholder="Name" class="border border-gray-300 rounded-md w-full p-2 text-sm w-[300px]"/>
                        </td>
                        <td style="text-align: left;">
                            <button @click="searchMember" class="px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-600 focus:outline-none">
                                Search <i class="fas fa-magnifying-glass ml-1"></i>
                            </button>
                        </td>
                    
                        <td style="width:800px;text-align: right;">
                            <div v-if="$page.props.auth.user.role == 1">
                                <Link 
                                    :href="route('enroll')" 
                                    :active="route().current('members')"
                                    class="inline-flex items-center px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Enroll
                                    <i class="fas fa-plus ml-1"></i>
                                </Link>
                            </div>
                            <div v-else>
                                <Link 
                                    :href="route('moderator.enroll')" 
                                    :active="route().current('moderator.members')"
                                    class="inline-flex items-center px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Enroll
                                    <i class="fas fa-plus ml-1"></i>
                                </Link>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="p-4 sm:p-2 bg-white shadow sm:rounded-lg">
                    <table style="width: 100%;" class="min-w-full divide-y text-blue-900">
                        <tr>
                            <td class="p-1 w-[200px]">
                                <table class="min-w-full divide-y divide-gray-200 shadow-sm text-blue-900">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="(member, index) in scmembers.data" :key="index" @click="handleSelectRow(member)">
                                            <td class="px-6 py-1 whitespace-nowrap uppercase cursor-pointer">
                                                <b>{{ member.last_name }}</b>, {{ member.first_name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        
                            <td class="p-2 w-[800px]">
                                <table class="min-w-full divide-y divide-gray-200 shadow-sm text-blue-900">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member Details</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-6 py-1 whitespace-nowrap uppercase cursor-pointer">
                                                <div v-if="selectedMember == null"></div>
                                                <div v-else>
                                                    <b>{{selectedMember.first_name}}</b>
                                                </div>
                                            </td>
                                        </tr>
                                        {{selectedMember}}
                                        {{selectedMember}}
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- <div class="p-4 sm:p-2 bg-white shadow sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 shadow-sm text-blue-900">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[300px]">Date of Birth</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(member, index) in scmembers.data" :key="index">
                                <td class="px-6 py-1 whitespace-nowrap uppercase"><b class="">{{ member.last_name }}</b>, {{ member.first_name }}</td>
                                <td class="px-6 py-1 whitespace-nowrap">{{ member.date_of_birth }}</td>
                                <td class="px-6 py-1 whitespace-nowrap">{{ member.gender }}</td>
                                <td class="px-6 py-1 whitespace-nowrap">{{ member.phone_number }}</td>
                                <td class="px-6 py-1 whitespace-nowrap">
                                    <a
                                        href="#"
                                        @click.prevent="openModal(member)"
                                        class="inline-flex items-center px-1 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-blue-500 mr-1"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a
                                        :href="`/admin/members/${member.id}`"
                                        class="inline-flex items-center px-1 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-blue-500 mr-1"
                                    >
                                        <i class="fas fa-file"></i>
                                    </a>
                                    <a
                                        :href="`/admin/members/${member.id}`"
                                        class="inline-flex items-center px-1 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-500 mr-2"
                                    >
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
                
                <!-- pagination -->
                <!-- <div class="flex justify-center">
                    <div v-for="(link, index) in scmembers.links" :key="index" class="m-1">
                        <button 
                            v-if="link.url" 
                            :class="['mt-4 px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-offset-2', link.active ? 'bg-violet-700 text-white' : 'bg-violet-400 hover:bg-violet-700 text-white']"
                            @click="() => $inertia.get(link.url)"
                        >
                            <div v-if="link.label.includes('Previous')">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Previous
                            </div>
                            <div v-else-if="link.label.includes('Next')">
                                Next
                                <i class="fas fa-arrow-right ml-2"></i>
                            </div>
                            <div v-else>
                                {{ link.label }}
                            </div>
                        </button>
                    </div>
                </div> -->

                <!-- modal -->
                <transition name="modal" @before-enter="beforeEnter" @enter="enter" @leave="leave">
                    <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="fixed inset-0 bg-black opacity-30"></div>
                            <div class="bg-white rounded-lg overflow-hidden shadow-xl z-10 max-w-lg w-full p-6 transform transition-all duration-500 ease-in-out scale-90" :class="{ 'scale-100': isModalOpen }">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Member</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">You can edit the member details here.</p>

                                    <input type="text" v-model="memberData.first_name" placeholder="First Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.last_name" placeholder="Last Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="date" v-model="memberData.date_of_birth" placeholder="Date of Birth" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.gender" placeholder="Gender" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.address" placeholder="Address" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.city" placeholder="City" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.state" placeholder="State" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.postal_code" placeholder="Postal Code" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.phone_number" placeholder="Phone Number" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="email" v-model="memberData.email" placeholder="Email" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.emergency_contact_name" placeholder="Emergency Contact Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <input type="text" v-model="memberData.emergency_contact_phone" placeholder="Emergency Contact Phone" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                                    <!-- <textarea v-model="memberData.medical_conditions" placeholder="Medical Conditions" class="mt-2 border border-gray-300 rounded-md w-full p-2"></textarea>
                                    <textarea v-model="memberData.medications" placeholder="Medications" class="mt-2 border border-gray-300 rounded-md w-full p-2"></textarea>
                                    <textarea v-model="memberData.allergies" placeholder="Allergies" class="mt-2 border border-gray-300 rounded-md w-full p-2"></textarea> -->
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Cancel</button>
                                    <button @click="saveChanges" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>

                <!-- Notification -->
                <div v-if="isVisible" :class="['fixed top-5 right-5 z-50 p-4 rounded shadow-md', notificationClass]">
                    <p>{{ message }}</p>
                    <!-- <button @click="isVisible = false" class="absolute top-2 right-2 text-lg font-bold text-white">×</button> -->
                </div>

            </div>
        <!-- </div> -->
    </AuthenticatedLayout>
</template>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.7s ease;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}
</style>
