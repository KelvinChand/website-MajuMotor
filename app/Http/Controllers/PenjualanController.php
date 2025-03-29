<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Barang;
use App\Models\PenjualanProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk')->get();
        return response()->json([
            'message' => 'Data Penjualan berhasil diambil',
            'data' => $Penjualan
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
                $barang = Barang::where('idProduk',$item['idProduk'])->first();
                if ($barang) {
                    if ($barang->stok < $item['kuantitas']) {
                        DB::rollBack();
                        return response()->json([
                            'message' => 'Stok tidak mencukupi untuk produk ' . $produk->nama,
                        ], 400);
                    }
                    $barang->decrement('stok', $item['kuantitas']);
                } else {
                    continue;
                }

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
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal Menyimpan Data Penjualan',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function updateStatus(Request $request, $idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);

        if (!$penjualan) {
            return response()->json(['message' => 'Data Penjualan Tidak Ditemukan'], 404);
        }

        $attributes = $request->validate([
            'status' => ['required', 'in:berhasil,gagal']
        ]);

        $penjualan->update(['status' => $attributes['status']]);

        return response()->json([
            'message' => 'Status Penjualan Berhasil Diperbarui',
            'Penjualan' => $penjualan
        ], 200);
    }

    public function destroy($idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);
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
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal Menghapus Data Penjualan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
