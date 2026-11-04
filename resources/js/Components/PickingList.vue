<template>
    <div class="p-6 bg-gray-800 border border-gray-700 rounded-xl shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-white">Picking List (Outbound)</h3>
            <span class="px-2.5 py-0.5 text-xs font-medium bg-blue-900/30 text-blue-400 rounded-full">
                Diurutkan sesuai Rute
            </span>
        </div>

        <div class="space-y-3">
            <div v-for="(item, index) in pickingList" :key="index" 
                 class="flex items-center justify-between p-4 bg-gray-900/50 border border-gray-700 rounded-lg">
                <div class="flex items-center gap-4">
                    <!-- Nomor Urut Rute -->
                    <div class="flex items-center justify-center w-8 h-8 font-bold text-gray-300 bg-gray-800 border border-gray-600 rounded-full">
                        {{ index + 1 }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ item.product_name }}</p>
                        <p class="text-xs text-gray-400">Ambil di: {{ item.location }} ({{ item.bin_code }})</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="block text-lg font-bold text-white">{{ item.qty_needed }}</span>
                    <span class="text-xs text-gray-500">Qty</span>
                </div>
            </div>
        </div>
        
        <button class="w-full mt-6 px-4 py-2 bg-red-600 hover:bg-red-500 text-white font-medium rounded-lg transition-colors">
            Selesaikan Picking
        </button>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const pickingList = ref([]);

onMounted(async () => {
    // Fetch data dari API generatePickingList
    const response = await fetch('/api/outbound/1/picking-list'); 
    const data = await response.json();
    pickingList.value = data.data;
});
</script>