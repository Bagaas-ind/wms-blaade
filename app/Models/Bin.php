<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bin extends Model
{
    use HasFactory;

    // Ini yang tadi kita tambahkan
    protected $fillable = ['rack_id', 'code', 'capacity'];

    // Ini relasi dari langkah sebelumnya
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }
}