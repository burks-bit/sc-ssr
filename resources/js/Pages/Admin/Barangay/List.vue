<script setup>
import { ref, toRefs, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    barangays: Object,
});

const emit = defineEmits(['close', 'save']);
const isModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const barangayData = ref({});
const isVisible = ref(false);
const message = ref('');
const notificationType = ref('');

const openEditModal = (member) => {
    barangayData.value = { ...member };
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const barangayForm = useForm({
    id: null,
    code: null,
    name: null,
    status: null
});

const saveChanges = () => {
    barangayForm.id = barangayData.value.id;
    barangayForm.code = barangayData.value.code;
    barangayForm.name = barangayData.value.name;
    barangayForm.status = barangayData.value.status;

    barangayForm.post('/admin/barangays/save', {
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

const openDeleteModal = (member) => {
    barangayData.value = { ...member };
    isDeleteModalOpen.value = true;
};

const closeDeleteModal = (member) => {
    isDeleteModalOpen.value = false;
};

const deleteBarangay = (id) => {
	router.post('/admin/barangays/remove', { id:id },
    {
        preserveState: true,
        onSuccess: () => {
            closeDeleteModal();
            showNotification('Barangay Deleted successfully!', 'success');
        }
    });
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
    <Head title="Barangays" />
    <AuthenticatedLayout headerTitle="Barangays">
        <div class="max-w-7xl mx-auto sm:px-6 space-y-6">
            <button @click="openEditModal" class="px-2 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-400 hover:bg-green-600 focus:outline-none">
                Add New Barangay <i class="fa fa-plus"></i></button>
            <div class="p-4 sm:p-2 bg-white shadow sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200 shadow-sm text-blue-900">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-[300px]">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="(barangay, index) in barangays.data" :key="index">
                            <td class="px-6 py-1 whitespace-nowrap uppercase"><b class="">{{ barangay.code }}</b></td>
                            <td class="px-6 py-1 whitespace-nowrap">{{ barangay.name }}</td>
                            <td class="px-6 py-1 whitespace-nowrap">
                                <a
                                    href="#"
                                    @click.prevent="openEditModal(barangay)"
                                    class="inline-flex items-center px-1 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-blue-500 mr-1"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a
                                    href="#"
                                    @click.prevent="openDeleteModal(barangay)"
                                    class="inline-flex items-center px-1 py-1 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-red-500 mr-2"
                                >
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
                
        <!-- pagination -->
        <div class="flex justify-center">
            <div v-for="(link, index) in barangays.links" :key="index" class="m-1">
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
        </div>

        <!-- modal -->
        <transition name="modal" @before-enter="beforeEnter" @enter="enter" @leave="leave">
            <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="fixed inset-0 bg-black opacity-30"></div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl z-10 max-w-lg w-full p-6 transform transition-all duration-500 ease-in-out scale-90" :class="{ 'scale-100': isModalOpen }">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Barangay</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">You can edit the barangay details here.</p>
                            <input type="text" v-model="barangayData.code" placeholder="First Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                            <input type="text" v-model="barangayData.name" placeholder="Last Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                            <input type="checkbox" v-model="barangayData.status" :true-value="1" :false-value="0"  class="mt-2 border border-gray-300 rounded-md p-2" />
                            <label for="status" class="ml-2">Active</label>
                       </div>
                        <div class="mt-4 flex justify-end">
                            <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Cancel</button>
                            <button @click="saveChanges" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- modal -->
        <transition name="modal" @before-enter="beforeEnter" @enter="enter" @leave="leave">
            <div v-if="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="fixed inset-0 bg-black opacity-30"></div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl z-10 max-w-lg w-full p-6 transform transition-all duration-500 ease-in-out scale-90" :class="{ 'scale-100': isModalOpen }">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Add Barangay</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">You can put the barangay details here.</p>
                            <input type="text" v-model="barangayData.code" placeholder="First Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                            <input type="text" v-model="barangayData.name" placeholder="Last Name" class="mt-2 border border-gray-300 rounded-md w-full p-2"/>
                            <input type="checkbox" v-model="barangayData.status" :true-value="1" :false-value="0"  class="mt-2 border border-gray-300 rounded-md p-2" />
                            <label for="status" class="ml-2">Active</label>
                       </div>
                        <div class="mt-4 flex justify-end">
                            <button @click="closeModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Cancel</button>
                            <button @click="saveChanges" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="modal" @before-enter="beforeEnter" @enter="enter" @leave="leave">
            <div v-if="isDeleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen">
                    <div class="fixed inset-0 bg-black opacity-30"></div>
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl z-10 max-w-lg w-full p-6 transform transition-all duration-500 ease-in-out scale-90" :class="{ 'scale-100': isModalOpen }">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Delete Barangay</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Are you sure you want to delete barangay <b class="text-red-500">{{ barangayData.name }}</b> ?</p>
                            
                       </div>
                        <div class="mt-4 flex justify-end">
                            <button @click="closeDeleteModal" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded-md">Cancel</button>
                            <button @click="deleteBarangay(barangayData.id)" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save</button>
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
