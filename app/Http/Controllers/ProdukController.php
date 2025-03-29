<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Barang;
use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{

    public function index()
    {
        $Produk = Produk::with('barang','jasa')->get();
        return response()->json([
            'message' => 'Data Produk berhasil diambil',
            'data' => $Produk
        ], 200);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'idProduk' => ['sometimes', 'string'],
            'nama' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'tipe' => ['required', 'in:barang,jasa'],
            'jenis' => ['sometimes', 'string'],
            'stok' => ['sometimes', 'integer', 'min:0'],
            'deskripsiKeluhan' => ['sometimes', 'string']

        ]);

        DB::beginTransaction();
        try {
            $produk = Produk::create($attributes);
            if (!$produk) {
                throw new \Exception('Gagal Menyimpan Data Produk');
            }
            $idProduk = $produk->idProduk;
            $attributes['idProduk'] = $idProduk;
            DB::commit();

            if ($attributes['tipe'] === 'barang') {
                $Barang = Barang::create($attributes);
                return response()->json([
                    'message' => 'Data Barang Berhasil Dibuat',
                    'data' => $Barang
                ]);
            } else {
                $Jasa = Jasa::create($attributes);
                return response()->json([
                    'message' => 'Data Jasa Berhasil Dibuat',
                    'data' => $Jasa
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal Menyimpan Data Produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $idProduk)
    {
        $Produk = Produk::find($idProduk);

        if (!$Produk) {
            return response()->json(['message' => 'Produk Tidak Ditemukan'], 404);
        }

        $attributes = $request->validate([
            'nama' => ['sometimes', 'string', 'max:50'],
            'harga' => ['sometimes', 'integer'],
        ]);

        $Produk->update($attributes);

        return response()->json(['message' => 'Data Produk Berhasil Diperbarui', 'Produk' => $Produk], 200);
    }

    public function destroy($idProduk)
    {
        $produk = Produk::find($idProduk);


        if (!$produk) {
            return response()->json(['message' => 'Produk Tidak Ditemukan'], 404);
        }

        DB::beginTransaction();
        try {

            Barang::where('idProduk', $idProduk)->delete();
            Jasa::where('idProduk', $idProduk)->delete();

            $produk->delete();

            DB::commit();

            return response()->json(['message' => 'Data Produk Berhasil Dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Gagal Menghapus Data Produk',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
