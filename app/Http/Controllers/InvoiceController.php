<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanProduk;
use App\Models\Produk;
use App\Models\Barang;
use App\Models\Jasa;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Validasi request
        $request->validate([
            'idPenjualan' => ['required', 'integer'],
        ]);

        $idPenjualan = $request->idPenjualan;

        // Ambil data penjualan dengan status 'berhasil'
        $penjualan = Penjualan::where('idPenjualan', $idPenjualan)
            ->where('status', 'berhasil')
            ->first();

        if (!$penjualan) {
            return response()->json([
                'message' => 'Penjualan tidak ditemukan atau belum berhasil'
            ], 404);
        }

        // Ambil data penjualan produk berdasarkan idPenjualan
        $penjualanProduk = PenjualanProduk::where('idPenjualan', $idPenjualan)->get();

        // Ambil data produk dan cek apakah barang atau jasa
        $produkList = [];
        foreach ($penjualanProduk as $pp) {
            $produk = Produk::find($pp->idProduk);

            if (!$produk) {
                continue;
            }

            $detail = [
                'idProduk' => $produk->idProduk,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'tipe' => $produk->tipe,
                'kuantitas' => $pp->kuantitas,
                'jumlah' => $pp->jumlah,
            ];

            // Cek apakah produk adalah barang atau jasa
            if ($produk->tipe === 'barang') {
                $barang = Barang::where('idProduk', $produk->idProduk)->first();
                $detail['barang'] = $barang ? $barang->only(['idBarang', 'stok', 'jenis']) : null;
            } elseif ($produk->tipe === 'jasa') {
                $jasa = Jasa::where('idProduk', $produk->idProduk)->first();
                $detail['jasa'] = $jasa ? $jasa->only(['idJasa', 'deskripsi_keluhan']) : null;
            }

            $produkList[] = $detail;
        }

        return response()->json([
            'message' => 'Data Invoice Berhasil Diambil',
            'penjualan' => $penjualan,
            'produk' => $produkList
        ], 200);
    }

    //Cetak Nota
}
