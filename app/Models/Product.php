<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ... (kode asli kamu seperti $fillable, dll biarkan saja) ...

    // TAMBAHKAN KODE INI DI SINI (sebelum kurung kurawal penutup)
    public function bins()
    {
        return $this->belongsToMany(Bin::class)->withPivot('quantity')->withTimestamps();
    }
}