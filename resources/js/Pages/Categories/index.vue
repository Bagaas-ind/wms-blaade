<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

// Menerima data dari Controller
defineProps({
    categories: Object
});

// Fungsi untuk hapus data
const deleteCategory = (id) => {
    if (confirm('Yakin ingin menghapus kategori ini?')) {
        router.delete(route('categories.destroy', id));
    }
};
</script>

<template>
    <Head title="Manajemen Kategori" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Kategori</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    
                    <div class="mb-4">
                        <Link :href="route('categories.create')" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
                            + Tambah Kategori
                        </Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">No</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama Kategori</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category, index) in categories.data" :key="category.id" class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ categories.from + index }}</td>
                                    <td class="py-3 px-4 border-b font-medium">{{ category.name }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <Link :href="route('categories.edit', category.id)" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</Link>
                                        <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                    </td>
                                </tr>
                                <tr v-if="categories.data.length === 0">
                                    <td colspan="3" class="text-center py-6 text-gray-500">Belum ada data kategori.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Sederhana -->
                    <div class="mt-4 flex gap-2">
                        <Link v-if="categories.prev_page_url" :href="categories.prev_page_url" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Previous</Link>
                        <Link v-if="categories.next_page_url" :href="categories.next_page_url" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Next</Link>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>