<script setup>
import { ref, toRefs, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    scmembers: Object,
});

// console.log(toRefs(props.scmembers.data))

const emit = defineEmits(['close', 'save']);
const isModalOpen = ref(false);
const memberData = ref({});
const isVisible = ref(false);
const message = ref('');
const notificationType = ref('');

// Initialize search member form
const searchMemberForm = useForm({
    name: ''
});

// Store search results
const filteredMembers = ref([]);

const searchMember = () => {
    searchMemberForm.get('/admin/members/list', {
        preserveScroll: true,
        onSuccess: () => {
            showNotification('Search completed', 'success');
        },
        onError: (error) => {
            console.error('Error searching member:', error);
            showNotification('Error occurred. Please try again.', 'error');
        }
    });
}



// Selected member
const selectedMember = ref(null);
const handleSelectRow = (member) => {
    selectedMember.value = member;
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
    <Head title="SC Members" />
    <AuthenticatedLayout headerTitle="Members">
        <div class="max-w-7xl mx-auto sm:px-6 space-y-6">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <input type="text" v-model="searchMemberForm.name" placeholder="Name" class="border border-gray-300 rounded-md w-full p-2 text-sm w-[300px]" />
                    </td>
                    <td style="text-align: left;">
                        <button @click="searchMember" class="px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-600 focus:outline-none">
                            Search <i class="fas fa-magnifying-glass ml-1"></i>
                        </button>
                    </td>
                    <td style="width:800px;text-align: right;">
                        <Link
                            :href="route($page.props.auth.user.role == 1 ? 'enroll' : 'moderator.enroll')"
                            :active="route().current($page.props.auth.user.role == 1 ? 'members' : 'moderator.members')"
                            class="inline-flex items-center px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Enroll
                            <i class="fas fa-plus ml-1"></i>
                        </Link>
                    </td>
                </tr>
            </table>

            <!-- Main grid with 2 columns -->
            <div class="grid grid-cols-2 gap-4 p-2 bg-white shadow sm:rounded-lg" style="height: 500px;">
                
                <!-- Members Search Results Column -->
                <div class="overflow-y-auto" style="max-height: 100%; border-right: 1px solid #e5e7eb;">
                    <table style="width: 100%;" class="min-w-full divide-y text-blue-900">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members Search Results</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(member, index) in scmembers" :key="index" @click="handleSelectRow(member)">
                                <td class="px-6 py-1 whitespace-nowrap uppercase cursor-pointer highlighted">
                                    <b>{{ member.last_name }}</b>, {{ member.first_name }}
                                </td>
                            </tr>
                            <tr v-if="scmembers.length === 0">
                                <td colspan="1" class="text-center">No results found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Member Details Column -->
                <div class="w-full" style="">
                    <table class="min-w-full divide-y divide-gray-200 shadow-sm text-blue-900" style="height: 100%;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-1 whitespace-nowrap">
                                    <div v-if="selectedMember == null">Select a member to view details</div>
                                    <div v-else>
                                        <b>{{ selectedMember.first_name }}</b> {{ selectedMember.last_name }} <br>
                                        <span>Date of Birth: {{ selectedMember.date_of_birth }}</span> <br>
                                        <span>Address: {{ selectedMember.address }}</span> <br>
                                        <span>City: {{ selectedMember.city }}</span> <br>
                                        <span>State: {{ selectedMember.state }}</span> <br>
                                        <span>Postal Code: {{ selectedMember.postal_code }}</span> <br>
                                        <span>Phone: {{ selectedMember.phone_number }}</span> <br>
                                        <span>Email: {{ selectedMember.email }}</span> <br>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Notification -->
            <div v-if="isVisible" :class="['fixed top-5 right-5 z-50 p-4 rounded shadow-md', notificationClass]">
                <p>{{ message }}</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.modal-enter-active, .modal-leave-active {
    transition: opacity 0.7s ease;
}
.modal-enter, .modal-leave-to {
    opacity: 0;
}

.highlighted:hover {
    background-color: rgb(208, 235, 255);
    transition: 0.6s ease;
}

.overflow-y-auto {
    overflow-y: scroll; /* Still allow scrolling */
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.overflow-y-auto::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.grid-cols-2 > div {
    min-height: 100%;
    display: flex;
    flex-direction: column;
}

/* Make the table header sticky */
thead.sticky {
    position: sticky;
    top: 0;
    background-color: #f9fafb; /* Ensure the header has a background color */
    z-index: 10; /* Make sure it's above other content */
}
</style>

