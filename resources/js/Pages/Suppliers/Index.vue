<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({ suppliers: Object });

const deleteSupplier = (id) => {
    if (confirm('Yakin ingin menghapus supplier ini?')) {
        router.delete(route('suppliers.destroy', id));
    }
};
</script>

<template>
    <Head title="Manajemen Supplier" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">Manajemen Supplier</h2>
        </template>

        <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    
                    <div class="mb-6 flex justify-between items-center">
                        <Link :href="route('suppliers.create')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Supplier
                        </Link>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">No</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Nama Supplier</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Telepon</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Alamat</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr v-for="(supplier, index) in suppliers.data" :key="supplier.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-300">{{ suppliers.from + index }}</td>
                                    <td class="py-4 px-4 text-sm font-bold text-gray-800 dark:text-gray-100">{{ supplier.name }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-300">{{ supplier.phone || '-' }}</td>
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-300">{{ supplier.address || '-' }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex justify-center gap-3">
                                            <Link :href="route('suppliers.edit', supplier.id)" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-sm">Edit</Link>
                                            <button @click="deleteSupplier(supplier.id)" class="text-red-600 dark:text-red-400 hover:underline font-semibold text-sm">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="suppliers.data.length === 0">
                                    <td colspan="5" class="text-center py-8 text-gray-500 dark:text-gray-400">Belum ada data supplier.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>