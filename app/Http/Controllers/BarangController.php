<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $produk = Produk::create([
                'nama' => $attributes['nama'],
                'harga' => $attributes['harga'],
            ]);

            if (!$produk || !$produk->idProduk) {
                throw new \Exception('Gagal menyimpan data produk');
            }

            $barang = Barang::create([
                'idProduk' => $produk->idProduk,
                'jenis' => $attributes['jenis'] ?? null,
                'stok' => $attributes['stok'] ?? 0,
            ]);

            DB::commit();
            return redirect()->route('barang.indexWeb')->with('success', 'Data barang berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('barang.indexWeb')->with('error', 'Data barang gagal disimpan.');
        }
    }

    public function update(Request $request, $idBarang)
    {
        $Barang = Barang::find($idBarang);

        if (!$Barang) {
            return redirect()->route('barang.indexWeb')->with('error', 'Data barang tidak ditemukan.');
        }

        $attributes = $request->validate([
            'nama' => ['string'],
            'harga' => ['numeric'],
            'jenis' => ['string', 'max:50'],
            'stok' => ['integer'],
        ]);

        DB::beginTransaction();
        try {
            $Barang->update(['jenis' => $attributes['jenis']]);
            $Barang->produk->update([
                'nama' => $attributes['nama'],
                'harga' => $attributes['harga'],
            ]);

            if (isset($attributes['stok'])) {
                $Barang->stok = $attributes['stok'];
                $Barang->save();
            }

            DB::commit();
            return redirect()->route('barang.indexWeb')->with('success', 'Data barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('barang.indexWeb')->with('error', 'Data barang gagal diperbarui.');
        }
    }

    public function destroy($idBarang)
    {
        $Barang = Barang::find($idBarang);

        if (!$Barang) {
            return redirect()->route('barang.indexWeb')->with('error', 'Data barang tidak ditemukan.');
        }

        $Barang->delete();
        return redirect()->route('barang.indexWeb')->with('success', 'Data barang berhasil dihapus.');
    }
}
