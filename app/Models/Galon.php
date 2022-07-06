<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galon extends Model
{
    use HasFactory;
    protected $table = 'galons';
    protected $fillable = [
        'merk',
        'isi_galon',
        'jml_stok',
        'harga_awal',
        'harga_jual',
        'gambar_galon',
        'created_at',
        'updated_at'
    ];
}
