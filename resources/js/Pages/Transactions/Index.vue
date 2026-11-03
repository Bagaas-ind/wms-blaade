<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({ transactions: Object });

const printTransaction = (trx) => {
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
                    <p>WMS BLAADE - Sistem Manajemen Gudang</p>
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
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">Riwayat Transaksi Gudang</h2>
        </template>

        <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                    
                    <div class="mb-6 flex justify-between items-center">
                        <Link :href="route('transactions.create')" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition-all transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Buat Transaksi Baru
                        </Link>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Tanggal</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Produk</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Tipe</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Qty</th>
                                    <th class="py-4 px-4 border-b dark:border-gray-700 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                <tr v-for="trx in transactions.data" :key="trx.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 px-4 text-sm text-gray-600 dark:text-gray-300">{{ new Date(trx.date).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) }}</td>
                                    <td class="py-4 px-4 text-sm font-bold text-gray-800 dark:text-gray-100">{{ trx.product?.name }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span v-if="trx.type === 'in'" class="bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 text-xs font-bold px-3 py-1 rounded-full border border-green-200 dark:border-green-800">MASUK</span>
                                        <span v-else class="bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 text-xs font-bold px-3 py-1 rounded-full border border-red-200 dark:border-red-800">KELUAR</span>
                                    </td>
                                    <td class="py-4 px-4 text-center text-sm font-black text-gray-800 dark:text-gray-100">{{ trx.quantity }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <button @click="printTransaction(trx)" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 font-bold text-xs px-4 py-2 rounded-lg transition-colors border border-gray-200 dark:border-gray-600 flex items-center justify-center gap-2 mx-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            Cetak
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="transactions.data.length === 0">
                                    <td colspan="5" class="text-center py-8 text-gray-500 dark:text-gray-400">Belum ada riwayat transaksi.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>