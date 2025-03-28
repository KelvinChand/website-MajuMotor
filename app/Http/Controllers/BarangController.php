<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Produk;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $Barang = Barang::with('produk')->get();
        return response()->json([
            'message' => 'Data Barang berhasil diambil',
            'data' => $Barang
        ], 200);
    }


    // public function update(Request $request, $idBarang)
    // {
    //     $Barang = Barang::find($idBarang);

    //     if (!$Barang) {
    //         return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    //     }

    //     $attributes = $request->validate([
    //         'jenis' => ['string', 'max:50'],
    //         'stok' => ['integer'],
    //     ]);

    //     $Barang->update($attributes);
    //     return response()->json(['message' => 'Data Barang Berhasil Diperbarui', 'Barang' => $Barang], 200);
    // }

    // public function destroy($idBarang)
    // {
    //     $Barang = Barang::find($idBarang);

    //     if (!$Barang) {
    //         return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    //     }

    //     $Barang->delete();
    //     return response()->json(['message' => 'Data Barang Berhasil Dihapus'], 200);
    // }
}
