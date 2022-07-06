<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanKurirController extends Controller
{
    function index($id){
        $belumTransaksi = Transaksi::where([
                ['id_kurir', $id],
                ['status', '0']
            ])->count();
        $belumDibayar = Transaksi::where([
                ['id_kurir', $id],
                ['status', '1']
            ])->count();
        $pembayaranGagal = Transaksi::where([
                ['id_kurir', $id],
                ['status', '2']
            ])->count();
        $belumDikirim = Transaksi::where([
                ['id_kurir', $id],
                ['status', '3']
            ])->count();
        $selesai = Transaksi::where([
                ['id_kurir', $id],
                ['status', '4']
            ])->count();
        $dibatalkan = Transaksi::where([
                ['id_kurir', $id],
                ['status', '5']
            ])->count();
        
        return response()->json([
            'status'    => true,
            'data'      => [
                $belumTransaksi,
                $belumDibayar,
                $pembayaranGagal,
                $belumDikirim,
                $selesai,
                $dibatalkan
            ]
        ]);
    }
}
