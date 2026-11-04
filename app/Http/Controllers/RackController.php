<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use Illuminate\Http\Request;

class RackController extends Controller
{
    public function index()
    {
        // Mengambil semua bin beserta total stok saat ini
        $bins = Bin::withSum('products as total_stock', 'bin_product.quantity')->get();

        $formattedBins = $bins->map(function ($bin) {
            $isFull = $bin->total_stock >= $bin->capacity;
            return [
                'id' => $bin->id,
                'code' => $bin->code,
                'capacity' => $bin->capacity,
                'current_stock' => $bin->total_stock ?? 0,
                'status' => $isFull ? 'Full' : ($bin->total_stock > 0 ? 'Partial' : 'Empty'),
                'percentage' => $bin->capacity > 0 ? round(($bin->total_stock / $bin->capacity) * 100) : 0
            ];
        });

        return response()->json(['data' => $formattedBins]);
    }
}