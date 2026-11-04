public function generatePickingList($outbound_id)
{
    // Asumsi kita punya model OutboundRequest dan relasinya ke detail barang
    $outbound = OutboundRequest::with('items.product')->findOrFail($outbound_id);
    
    $pickingList = [];

    foreach ($outbound->items as $item) {
        // Cari produk ini disimpan di bin mana saja
        $productBins = $item->product->bins()->with('rack.zone')->get();
        
        // Ambil satu bin yang punya stok (untuk simplifikasi)
        $targetBin = $productBins->firstWhere('pivot.quantity', '>', 0);
        
        if ($targetBin) {
            $pickingList[] = [
                'product_name' => $item->product->name,
                'qty_needed' => $item->quantity,
                'location' => $targetBin->rack->zone->name . ' - ' . $targetBin->rack->name,
                'bin_code' => $targetBin->code,
                'sequence' => $targetBin->rack->sequence // Untuk sorting
            ];
        }
    }

    // URUTKAN BERDASARKAN RUTE TERDEKAT (Sequence Rak)
    usort($pickingList, function($a, $b) {
        return $a['sequence'] <=> $b['sequence'];
    });

    return response()->json([
        'status' => 'success',
        'data' => $pickingList
    ]);
}