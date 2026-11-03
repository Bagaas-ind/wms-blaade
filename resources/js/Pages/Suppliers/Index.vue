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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Supplier</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4">
                        <Link :href="route('suppliers.create')" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Tambah Supplier</Link>
                    </div>

                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">No</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Nama</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Telepon</th>
                                <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Alamat</th>
                                <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(supplier, index) in suppliers.data" :key="supplier.id" class="hover:bg-gray-50">
                                <td class="py-3 px-4 border-b">{{ suppliers.from + index }}</td>
                                <td class="py-3 px-4 border-b font-medium">{{ supplier.name }}</td>
                                <td class="py-3 px-4 border-b">{{ supplier.phone || '-' }}</td>
                                <td class="py-3 px-4 border-b">{{ supplier.address || '-' }}</td>
                                <td class="py-3 px-4 border-b text-center">
                                    <Link :href="route('suppliers.edit', supplier.id)" class="text-blue-600 hover:text-blue-900 mr-3 font-semibold">Edit</Link>
                                    <button @click="deleteSupplier(supplier.id)" class="text-red-600 hover:text-red-900 font-semibold">Hapus</button>
                                </td>
                            </tr>
                            <tr v-if="suppliers.data.length === 0">
                                <td colspan="5" class="text-center py-6 text-gray-500">Belum ada data supplier.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>