<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JasaController extends Controller
{
    public function index()
    {
        $Jasa = Jasa::with('produk')->get();
        return response()->json([
            'message' => 'Data Jasa berhasil diambil',
            'data' => $Jasa
        ], 200);
    }
    public function indexWeb()
    {
        $jasa = Jasa::with('produk')->get();
        return view('product.jasa', compact('jasa'));
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'nama' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
            'deskripsiKeluhan' => ['required', 'string'],
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
            $jasa = Jasa::create([
                'idProduk' => $produk->idProduk,
                'deskripsiKeluhan' => $attributes['deskripsiKeluhan'] ?? null,
            ]);

            DB::commit();
            return redirect('jasa')->with("Berhasil Menyimpan Data");
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Menyimpan Data', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $idJasa)
    {
        $Jasa = Jasa::find($idJasa);

        if (!$Jasa) {
            return response()->json(['message' => 'Jasa tidak ditemukan'], 404);
        }

        $attributes = $request->validate([
            'deskripsiKeluhan' => ['string'],
            'nama' => ['required', 'string'],
            'harga' => ['required', 'numeric'],
        ]);

        DB::beginTransaction();

        try {
            $Jasa->update(['deskripsiKeluhan' => $attributes['deskripsiKeluhan']]);
            $Jasa->produk->update([
                'nama' => $attributes['nama'],
                'harga' => $attributes['harga'],
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back();
        }
    }

    public function destroy($idJasa)
    {
        $Jasa = Jasa::find($idJasa);

        if (!$Jasa) {
            return response()->json(['message' => 'Jasa Tidak Ditemukan'], 404);
        }

        $Jasa->delete();
        return response()->json(['message' => 'Data Jasa Berhasil Dihapus'], 200);
    }
}
