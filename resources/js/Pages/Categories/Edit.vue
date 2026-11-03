<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Menerima data kategori dari Controller
const props = defineProps({
    category: Object
});

// Mengisi form dengan data yang sudah ada
const form = useForm({
    name: props.category.name
});

const submit = () => {
    // Mengirim data update menggunakan PUT
    form.put(route('categories.update', props.category.id));
};
</script>

<template>
    <Head title="Edit Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori</h2>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                            <input 
                                type="text" 
                                v-model="form.name" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                required
                            >
                            <div v-if="form.errors.name" class="text-red-500 text-xs italic mt-2">
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button 
                                type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow"
                                :disabled="form.processing"
                            >
                                Update
                            </button>
                            <Link :href="route('categories.index')" class="text-gray-600 hover:underline">Batal</Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>