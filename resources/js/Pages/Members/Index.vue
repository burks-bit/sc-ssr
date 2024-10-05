<script setup>
import { onMounted, ref, toRefs, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    scmembers: Object,
    userRole: String,
    notif: String
});

const { userRole: userRoleRef } = toRefs(props);
const role = userRoleRef.value;

const { notif: notifRef } = toRefs(props);
const notif = computed(() => notifRef.value);

const EnrolledNotif = () => {
    if (notif.value) {
        showNotification('New Member Enrolled Successfully!', 'success');
    }
};

onMounted(() => {
    EnrolledNotif();
});

const emit = defineEmits(['close', 'save']);
const isVisible = ref(false);
const message = ref('');
const notificationType = ref('');

const searchMemberForm = useForm({
    name: ''
});

const filteredMembers = ref([]);

const searchMember = () => {
    searchMemberForm.get(`/${role}/members/list`, {
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
            <div class="mb-4 flex justify-between items-center">
                <div class="flex space-x-2">
                    <input
                        type="text"
                        v-model="searchMemberForm.name"
                        placeholder="Name"
                        class="border border-gray-300 rounded-md w-[300px] p-2 text-sm"
                    />
                    <button
                        @click="searchMember"
                        class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-600 focus:outline-none"
                    >
                        Search <i class="fas fa-magnifying-glass ml-1"></i>
                    </button>
                </div>
                <div>
                    <Link
                        :href="route(role === 'admin' ? 'admin.members.enroll' : 'moderator.members.enroll')"
                        :active="route().current(role === 'admin' ? 'members' : 'moderator.members')"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none"
                    >
                        Enroll
                        <i class="fas fa-plus ml-1"></i>
                    </Link>
                </div>
            </div>

            <!-- Two-Column Grid Layout with Custom Widths -->
            <div class="grid grid-cols-3 gap-4" style="height: 500px;">
                <!-- Member Search Results Column (1/3 of the grid) -->
                <div class="overflow-y-auto sm:rounded-lg" style="max-height: 100%; border-right: 1px solid #e5e7eb;">
                    <table style="width: 100%;" class="min-w-full divide-y text-blue-900">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Members Search Results</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr 
                                v-for="(member, index) in scmembers" 
                                :key="index" 
                                @click="handleSelectRow(member)" 
                                class="cursor-pointer hover:bg-blue-100 transition duration-300 ease-in-out"
                            >
                                <td class="px-6 py-2 whitespace-nowrap uppercase flex items-center space-x-2">
                                    <img 
                                        :src="member.gender === 'Male' ? '/images/male.png' : '/images/female.png'" 
                                        alt="Senior Citizen" 
                                        class="w-8 h-8 rounded-full mr-2" 
                                    />
                                    <div class="leading-tight">
                                        <p class="font-bold">{{ member.last_name }}, {{ member.first_name }}</p>
                                        <small class="text-gray-500" style="font-size: 9px;">{{ member.senior_citizen_id_no }}</small>
                                    </div>
                                </td>
                            </tr>
                            <tr v-if="scmembers.length === 0">
                                <td colspan="1" class="text-center">No results found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Member Details Column (2/3 of the grid) -->
                <div class="col-span-2 bg-white shadow sm:rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-4">Member Details</h2>
                    <!-- <div v-if="selectedMember == null">
                        <img 
                            src="/images/imageLoader.png" 
                            alt="imageLoader" 
                            class="h-[174px]" 
                        />
                    </div> -->
                    <!-- Skeleton Loader if no member is selected -->
                    <div v-if="selectedMember == null" class="animate-pulse space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="sm:rounded-md bg-gray-300 h-28 w-24"></div>
                            <div class="flex-1 space-y-3 py-1">
                                <div class="h-4 bg-gray-300 rounded w-4/4"></div>
                                <div class="h-4 bg-gray-300 rounded w-4/4"></div>
                                <div class="h-4 bg-gray-300 rounded w-4/4"></div>
                                <div class="h-4 bg-gray-300 rounded w-4/4"></div>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="h-4 bg-gray-300 rounded w-1/4"></div>
                            <div class="h-4 bg-gray-300 rounded w-1/3"></div>
                            <div class="h-4 bg-gray-300 rounded w-1/5"></div>
                        </div>
                    </div>
                    <div v-else class="flex items-center">
                        <img 
                            :src="selectedMember.gender === 'Male' ? '/images/male_square.png' : '/images/female_square.png'" 
                            alt="Senior Citizen" 
                            class="h-[115px] mr-4 sm:rounded-md" 
                        />
                        <div>
                            <p><strong>Senior Citizen ID No.:</strong> {{ selectedMember.senior_citizen_id_no }}</p>
                            <p><strong>First Name:</strong> {{ selectedMember.first_name }}</p>
                            <p><strong>Last Name:</strong> {{ selectedMember.last_name }}</p>
                            <p><strong>Gender:</strong> {{ selectedMember.gender }}</p>
                            <p><strong>Phone:</strong> {{ selectedMember.phone_number }}</p>
                        </div>
                    </div>
                    <div v-if="selectedMember != null" class="pt-4">
                        <button class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-violet-400 hover:bg-violet-600 focus:outline-none">
                            View <i class="fa fa-eye ml-1"></i>
                        </button>
                        &nbsp;
                        <button class="px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-400 hover:bg-red-600 focus:outline-none">
                            Print <i class="fa fa-print ml-1"></i>
                        </button>
                    </div>
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

thead.sticky {
    position: sticky;
    top: 0;
    background-color: #f9fafb; /* Ensure the header has a background color */
    z-index: 10; /* Make sure it's above other content */
}
</style>
