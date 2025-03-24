<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $Produk = Produk::all();
        return view('/', compact('Produk'));
    }
    public function show($id)
    {
        $Produk = Produk::findOrFail($id);
        return response()->json(['Produk' => $Produk], 200);
    }
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nama' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'tipe' => ['required', 'in:barang,jasa'],
        ]);

        if ($request->tipe === 'barang') {
            $request->validate([
                'jenis' => ['required', 'string'],
                'stok' => ['required', 'integer', 'min:0']
            ]);
        } elseif ($request->tipe === 'jasa') {
            $request->validate([
                'deskripsi_keluhan' => ['required', 'string']
            ]);
        }

        DB::beginTransaction();

        try {
            $produk = Produk::create($attributes);
            if (!$produk) {
                throw new \Exception('Gagal menyimpan data produk');
            }
            $idProduk = $produk->idProduk;
            DB::commit();

            if ($attributes['tipe'] === 'barang') {
                $response = app(BarangController::class)->store(idProduk: $idProduk, jenis: $request->jenis, stok: $request->stok);
                return response()->json($response);
            } else {
                $response = app(JasaController::class)->store(idProduk: $idProduk, deskripsiKeluhan: $request->deskripsiKeluhan);
                return response()->json($response);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal Menyimpan Data Produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $Produk = Produk::find($id);

        if (!$Produk) {
            return response()->json(['message' => 'Produk Tidak Ditemukan'], 404);
        }

        $attributes = $request->validate([
            'nama' => ['required', 'string', 'max:50'],
            'harga' => ['required', 'integer'],
        ]);

        $Produk->update($attributes);

        return response()->json(['message' => 'Data Produk Berhasil Diperbarui', 'Produk' => $Produk], 200);
    }

    public function destroy($id)
    {
        $Produk = Produk::find($id);

        if (!$Produk) {
            return response()->json(['message' => 'Produk Tidak Ditemukan'], 404);
        }

        $Produk->delete();
        return response()->json(['message' => 'Data Produk Berhasil Dihapus'], 200);
    }
}
