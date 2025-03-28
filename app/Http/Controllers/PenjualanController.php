<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\PenjualanProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::all();
        //Cari PenjualanProduk berdasarkan id Penjualan di table PenjualanProduk
        return response()->json([
            'message' => 'Data Penjualan berhasil diambil',
            'data' => $Penjualan
        ], 200);
    }

    public function show($idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);
        //Cari PenjualanProduk berdasarkan id Penjualan di table PenjualanProduk

        if (!$penjualan) {
            return response()->json(['message' => 'Data Penjualan Tidak Ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail Data Penjualan',
            'Penjualan' => $penjualan
        ], 200);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'data' => ['required', 'array'],
            'data.*.idProduk' => ['required', 'string'],
            'data.*.kuantitas' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $status = 'pending';
            $totalHarga = 0;
            $penjualan = Penjualan::create([
                'status' => $status,
                'totalHarga' => $totalHarga,
            ]);

            foreach ($attributes['data'] as $item) {
                $produk = Produk::findOrFail($item['idProduk']);
                $subTotal = $produk->harga * $item['kuantitas'];
                $totalHarga += $subTotal;
                PenjualanProduk::create([
                    'idPenjualan' => $penjualan->idPenjualan,
                    'idProduk' => $item['idProduk'],
                    'jumlah' => $subTotal,
                    'kuantitas' => $item['kuantitas'],
                ]);
            }
            $penjualan->update(['totalHarga' => $totalHarga]);

            DB::commit();
            return response()->json([
                'message' => 'Data Penjualan Berhasil Dibuat',
                'Penjualan' => $penjualan
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal Menyimpan Data Penjualan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);
        //Hapus PenjualanProduk dulu baru Penjualan
        if (!$penjualan) {
            return response()->json(['message' => 'Data Penjualan Tidak Ditemukan'], 404);
        }

        DB::beginTransaction();
        try {
            PenjualanProduk::where('idPenjualan', $idPenjualan)->delete();
            $penjualan->delete();
            DB::commit();

            return response()->json(['message' => 'Data Penjualan Berhasil Dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal Menghapus Data Penjualan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
