<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksis';
    protected $fillable = [
        'id_pelanggan',
        'id_karyawan',
        'id_kurir',
        'id_diskon',
        'jenis_potongan',
        'diskon',
        'ongkir',
        'total',
        'bukti_transaksi',
        'status',
        'keterangan',
        'created_at',
        'updated_at'
    ];
}
