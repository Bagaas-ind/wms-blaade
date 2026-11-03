<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({ name: '', phone: '', address: '' });
const submit = () => { form.post(route('suppliers.store')); };
</script>

<template>
    <Head title="Tambah Supplier" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Supplier</h2></template>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nama Supplier</label>
                            <input type="text" v-model="form.name" class="shadow border rounded w-full py-2 px-3" required>
                            <div v-if="form.errors.name" class="text-red-500 text-xs mt-2">{{ form.errors.name }}</div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Telepon (Opsional)</label>
                            <input type="text" v-model="form.phone" class="shadow border rounded w-full py-2 px-3">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Alamat (Opsional)</label>
                            <textarea v-model="form.address" rows="3" class="shadow border rounded w-full py-2 px-3"></textarea>
                        </div>
                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded" :disabled="form.processing">Simpan</button>
                            <Link :href="route('suppliers.index')" class="text-gray-600 hover:underline">Batal</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>