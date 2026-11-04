<template>
    <div class="p-6 bg-gray-800 border border-gray-700 rounded-xl shadow-sm">
        <h3 class="mb-4 text-base font-semibold text-white">Status Kapasitas Lokasi (Bin)</h3>
        
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-6">
            <div v-for="bin in bins" :key="bin.id" 
                 class="p-4 rounded-lg border flex flex-col items-center justify-center transition-all"
                 :class="{
                     'bg-gray-700/50 border-gray-600': bin.status === 'Empty',
                     'bg-yellow-900/20 border-yellow-700/50': bin.status === 'Partial',
                     'bg-red-900/20 border-red-700/50': bin.status === 'Full'
                 }">
                 
                 <span class="text-sm font-bold text-gray-200">{{ bin.code }}</span>
                 <span class="text-xs text-gray-400 mt-1">{{ bin.current_stock }} / {{ bin.capacity }}</span>
                 
                 <!-- Progress Bar -->
                 <div class="w-full bg-gray-900 rounded-full h-1.5 mt-3">
                     <div class="h-1.5 rounded-full" 
                          :class="bin.status === 'Full' ? 'bg-red-500' : 'bg-yellow-500'"
                          :style="{ width: bin.percentage + '%' }"></div>
                 </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const bins = ref([]);

onMounted(async () => {
    // Ganti dengan pemanggilan API axios/fetch milikmu
    // Jika route API kamu di Laravel, jangan lupa tambahkan prefix /api
    const response = await fetch('/api/racks'); 
    const data = await response.json();
    bins.value = data.data;
});
</script>