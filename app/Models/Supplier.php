<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    // Baris ini wajib ada agar Laravel mengizinkan penyimpanan data (Mass Assignment)
    // Kecuali untuk kolom 'id' yang otomatis diurus database.
    protected $guarded = ['id'];
}