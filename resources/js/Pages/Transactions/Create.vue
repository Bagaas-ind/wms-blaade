<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({ products: Array });

const form = useForm({
    product_id: '',
    type: 'in',
    quantity: '',
    date: new Date().toISOString().split('T')[0], // Tanggal hari ini
    note: ''
});

const submit = () => { form.post(route('transactions.store')); };
</script>

<template>
    <Head title="Buat Transaksi" />
    <AuthenticatedLayout>
        <template #header><h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Transaksi Baru</h2></template>
        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Pilih Produk</label>
                            <select v-model="form.product_id" class="shadow border rounded w-full py-2 px-3" required>
                                <option value="">-- Pilih Produk --</option>
                                <option v-for="prod in products" :key="prod.id" :value="prod.id">
                                    [{{ prod.sku }}] {{ prod.name }} (Stok: {{ prod.stock }})
                                </option>
                            </select>
                            <div v-if="form.errors.product_id" class="text-red-500 text-xs mt-2">{{ form.errors.product_id }}</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Tipe Transaksi</label>
                                <select v-model="form.type" class="shadow border rounded w-full py-2 px-3" required>
                                    <option value="in">Barang Masuk (Inbound)</option>
                                    <option value="out">Barang Keluar (Outbound)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Jumlah (Qty)</label>
                                <input type="number" v-model="form.quantity" class="shadow border rounded w-full py-2 px-3" required min="1">
                                <div v-if="form.errors.quantity" class="text-red-500 text-xs mt-2 font-bold">{{ form.errors.quantity }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Tanggal Transaksi</label>
                            <input type="date" v-model="form.date" class="shadow border rounded w-full py-2 px-3" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Keterangan / No. Referensi</label>
                            <textarea v-model="form.note" rows="2" class="shadow border rounded w-full py-2 px-3" placeholder="Contoh: Surat Jalan No. 123"></textarea>
                        </div>

                        <div class="flex justify-between items-center mt-6">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded" :disabled="form.processing">Proses Transaksi</button>
                            <Link :href="route('transactions.index')" class="text-gray-600 hover:underline">Batal</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>