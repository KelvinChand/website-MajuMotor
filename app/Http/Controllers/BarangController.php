<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Produk;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $Barang = Barang::all();
        return view('/', compact('Barang'));
    }

    public function store($idProduk, $jenis, $stok)
    {
        $attributes = request()->validate([
            'jenis' => $jenis,
            'stok' => $stok,
            'idProduk' => $idProduk,
        ]);

        $Barang = Barang::create($attributes);

        if (!$Barang) {
            return response()->json(['message' => 'Gagal Menyimpan Data Barang'], 500);
        }

        return response()->json(['message' => 'Data Barang Berhasil Dibuat', 'Barang' => $Barang], 201);
    }

    public function update(Request $request, $id)
    {
        $Barang = Barang::find($id);

        if (!$Barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $attributes = $request->validate([
            'jenis' => ['string', 'max:50'],
            'stok' => ['integer'],
        ]);

        $Barang->update($attributes);
        return response()->json(['message' => 'Data Barang Berhasil Diperbarui', 'Barang' => $Barang], 200);
    }

    public function destroy($id)
    {
        $Barang = Barang::find($id);

        if (!$Barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $Barang->delete();
        return response()->json(['message' => 'Data Barang Berhasil Dihapus'], 200);
    }
}
