<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk.barang', 'penjualanProduk.produk.jasa')->where('status', 'berhasil')->get();
        return response()->json([
            'message' => 'Data Invoice berhasil diambil',
            'data' => $Penjualan
        ], 200);
    }
}
