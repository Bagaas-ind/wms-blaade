<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ transactions: Object });

const printTransaction = (trx) => {
    // Membuat area cetak khusus
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>Surat Jalan - ${trx.id}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
                    .header h1 { margin: 0; font-size: 24px; }
                    .header p { margin: 5px 0 0 0; color: #555; }
                    .details { margin-bottom: 20px; width: 100%; border-collapse: collapse; }
                    .details th, .details td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
                    .details th { width: 30%; }
                    .footer { margin-top: 50px; text-align: right; }
                    .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; }
                    .bg-in { background: #d1fae5; color: #065f46; }
                    .bg-out { background: #fee2e2; color: #991b1b; }
                </style>
            </head>
            <body>
                <div class="header">
                    <h1>SURAT JALAN / BUKTI TRANSAKSI</h1>
                    <p>WMS BALDE - Sistem Manajemen Gudang</p>
                </div>
                <table class="details">
                    <tr><th>No. Transaksi</th><td>#TRX-${trx.id}</td></tr>
                    <tr><th>Tanggal</th><td>${new Date(trx.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })}</td></tr>
                    <tr><th>Nama Produk</th><td>${trx.product?.name || '-'}</td></tr>
                    <tr><th>SKU Produk</th><td>${trx.product?.sku || '-'}</td></tr>
                    <tr><th>Tipe Transaksi</th><td><span class="badge ${trx.type === 'in' ? 'bg-in' : 'bg-out'}">${trx.type === 'in' ? 'BARANG MASUK' : 'BARANG KELUAR'}</span></td></tr>
                    <tr><th>Jumlah (Qty)</th><td>${trx.quantity}</td></tr>
                    <tr><th>Petugas</th><td>${trx.user?.name || '-'}</td></tr>
                    <tr><th>Keterangan</th><td>${trx.note || '-'}</td></tr>
                </table>
                <div class="footer">
                    <p>Tanda Tangan Petugas,</p>
                    <br><br><br>
                    <p>( ${trx.user?.name || '....................'} )</p>
                </div>
                <script>
                    window.onload = function() { window.print(); }
                <\/script>
            </body>
        </html>
    `);
    printWindow.document.close();
};
</script>

<template>
    <Head title="Riwayat Transaksi" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Transaksi Gudang</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="mb-4">
                        <Link :href="route('transactions.create')" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">+ Buat Transaksi Baru</Link>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Tanggal</th>
                                    <th class="py-3 px-4 border-b text-left text-sm font-semibold text-gray-600">Produk</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Tipe</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Qty</th>
                                    <th class="py-3 px-4 border-b text-center text-sm font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="trx in transactions.data" :key="trx.id" class="hover:bg-gray-50">
                                    <td class="py-3 px-4 border-b">{{ new Date(trx.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}</td>
                                    <td class="py-3 px-4 border-b font-medium">{{ trx.product?.name }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <span v-if="trx.type === 'in'" class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-green-300">MASUK</span>
                                        <span v-else class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-red-300">KELUAR</span>
                                    </td>
                                    <td class="py-3 px-4 border-b text-center font-bold">{{ trx.quantity }}</td>
                                    <td class="py-3 px-4 border-b text-center">
                                        <button @click="printTransaction(trx)" class="text-blue-600 hover:text-blue-900 font-semibold border border-blue-600 px-3 py-1 rounded">
                                            🖨️ Cetak
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="transactions.data.length === 0">
                                    <td colspan="5" class="text-center py-6 text-gray-500">Belum ada riwayat transaksi.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>