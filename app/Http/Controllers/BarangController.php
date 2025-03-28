<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function indexWeb()
    {
        $barang = Barang::with('produk')->get();
        return view('product.barang', compact('barang'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nama' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'jenis' => ['required', 'string'],
            'stok' => ['required', 'integer', 'min:0']
        ]);

        DB::beginTransaction();

        try {
            // Simpan ke tabel produk
            $produk = Produk::create([
                'nama' => $attributes['nama'],
                'harga' => $attributes['harga'],
            ]);
            
            // Pastikan produk berhasil disimpan dan memiliki ID
            if (!$produk || !$produk->idProduk) {
                throw new \Exception('Gagal menyimpan data produk');
            }

            // Simpan ke tabel barang dengan idProduk yang valid
            $barang = Barang::create([
                'idProduk' => $produk->idProduk,
                'jenis' => $attributes['jenis'] ?? null,
                'stok' => $attributes['stok'] ?? 0,
            ]);

            DB::commit();
            return redirect('barang')->with("Berhasil Menyimpan Data");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Menyimpan Data', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $idBarang)
    {
        $Barang = Barang::find($idBarang);

        if (!$Barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $attributes = $request->validate([
            'jenis' => ['string', 'max:50'],
            'stok' => ['integer'],
        ]);

        $Barang->update($attributes);
        return redirect('barang')->with("Berhasil Mengupdate Data");
    }

    public function destroy($idBarang)
    {
        $Barang = Barang::find($idBarang);

        if (!$Barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $Barang->delete();
        return redirect('barang')->with("Berhasil Menghapus Data");
    }
}
