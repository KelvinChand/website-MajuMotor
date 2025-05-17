<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk')
        ->where('status', 'selesai')
        ->paginate(10);
        return view('jual.invoice', compact('Penjualan'));
    }

    public function indexRiwayat()
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk')->paginate(10);
        return view('jual.riwayat', compact('Penjualan'));
    }
}
