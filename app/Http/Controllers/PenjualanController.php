<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Barang;
use App\Models\Jasa;
use App\Models\PenjualanProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk')
            ->whereNotIn('status', ['selesai', 'gagal'])
            ->get();

        $jasa = Jasa::with('produk')->get();
        $barang = Barang::with('produk')->get();

        return view('jual.penjualan', compact('Penjualan', 'jasa', 'barang'));
    }

    // public function store(Request $request)
    // {
    //     $attributes = $request->validate([
    //         'data' => ['required', 'array'],
    //         'data.*.idProduk' => ['required', 'string'],
    //         'data.*.kuantitas' => ['required', 'integer', 'min:1'],
    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         $status = 'pending';
    //         $totalHarga = 0;
    //         $penjualan = Penjualan::create([
    //             'status' => $status,
    //             'totalHarga' => $totalHarga,
    //         ]);

    //         foreach ($attributes['data'] as $item) {
    //             $produk = Produk::findOrFail($item['idProduk']);
    //             $subTotal = $produk->harga * $item['kuantitas'];
    //             $totalHarga += $subTotal;
    //             $barang = Barang::where('idProduk', $item['idProduk'])->first();
    //             if ($barang) {
    //                 if ($barang->stok < $item['kuantitas']) {
    //                     DB::rollBack();
    //                     return response()->json([
    //                         'message' => 'Stok tidak mencukupi untuk produk ' . $produk->nama,
    //                     ], 400);
    //                 }
    //                 $barang->decrement('stok', $item['kuantitas']);
    //             } else {
    //                 continue;
    //             }

    //             PenjualanProduk::create([
    //                 'idPenjualan' => $penjualan->idPenjualan,
    //                 'idProduk' => $item['idProduk'],
    //                 'jumlah' => $subTotal,
    //                 'kuantitas' => $item['kuantitas'],
    //             ]);
    //         }

    //         $penjualan->update(['totalHarga' => $totalHarga]);

    //         DB::commit();
    //         return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil disimpan.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->route('penjualan.index')->with('error', 'Data penjualan gagal disimpan.');
    //     }
    // }

    public function store(Request $request)
    {
        // Pastikan request berupa JSON
        $attributes = $request->validate([
            'data' => ['required', 'array'],
            'data.*.idProduk' => ['required', 'string'],
            'data.*.kuantitas' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $status = 'pending';
            $totalHarga = 0;

            // Simpan data penjualan
            $penjualan = Penjualan::create([
                'status' => $status,
                'totalHarga' => $totalHarga,
            ]);

            foreach ($attributes['data'] as $item) {
                $produk = Produk::findOrFail($item['idProduk']);
                $subTotal = $produk->harga * $item['kuantitas'];
                $totalHarga += $subTotal;

                // Cek stok barang
                $barang = Barang::where('idProduk', $item['idProduk'])->first();
                if ($barang) {
                    if ($barang->stok < $item['kuantitas']) {
                        DB::rollBack();
                        return response()->json([
                            'message' => 'Stok tidak mencukupi untuk produk ' . $produk->nama,
                            'success' => false,
                        ], 400);
                    }
                    $barang->decrement('stok', $item['kuantitas']);
                }

                // Simpan data ke PenjualanProduk
                PenjualanProduk::create([
                    'idPenjualan' => $penjualan->idPenjualan,
                    'idProduk' => $item['idProduk'],
                    'jumlah' => $subTotal,
                    'kuantitas' => $item['kuantitas'],
                ]);
            }

            // Update total harga
            $penjualan->update(['totalHarga' => $totalHarga]);

            DB::commit();
            return response()->json([
                'message' => 'Data penjualan berhasil disimpan.',
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Data penjualan gagal disimpan.',
                'success' => false,
                'error' => $e->getMessage(),
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
            return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            PenjualanProduk::where('idPenjualan', $idPenjualan)->delete();
            $penjualan->delete();

            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('penjualan.index')->with('error', 'Terjadi kesalahan saat menghapus data penjualan: ' . $e->getMessage());
        }
    }
}
