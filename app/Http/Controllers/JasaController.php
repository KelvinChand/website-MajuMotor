<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class JasaController extends Controller
{
    public function index()
    {
        $Jasa = Jasa::with('produk')->paginate(10);
        return response()->json([
            'message' => 'Data Jasa berhasil diambil',
            'data' => $Jasa
        ], 200);
    }
    public function indexWeb()
    {
        $jasa = Jasa::with('produk')->paginate(10);
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
            $produk = Produk::create([
                'nama' => $attributes['nama'],
                'harga' => $attributes['harga'],
                'tipe' => "Jasa"
            ]);

            if (!$produk || !$produk->idProduk) {
                throw new \Exception('Gagal menyimpan data produk');
            }

            $jasa = Jasa::create([
                'idProduk' => $produk->idProduk,
                'deskripsiKeluhan' => $attributes['deskripsiKeluhan'] ?? null,
            ]);

            DB::commit();
            Alert::alert('Berhasil', 'Berhasil menambahkan data Jasa!', 'success');
            return redirect()->route('jasa.indexWeb');
            // return redirect()->route('jasa.indexWeb')->with('success', 'Data jasa berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::alert('Gagal', 'Gagal membuat data Jasa!', 'error');
            return redirect()->route('barang.indexWeb');
            // return redirect()->route('jasa.indexWeb')->with('error', 'Data jasa gagal disimpan.');
        }
    }

    public function update(Request $request, $idJasa)
    {
        $Jasa = Jasa::find($idJasa);

        if (!$Jasa) {
            return redirect()->route('jasa.indexWeb')->with('error', 'Data jasa tidak ditemukan.');
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
            Alert::alert('Berhasil', 'Berhasil mengupdate data Jasa!', 'success');
            return redirect()->route('jasa.indexWeb');
            // return redirect()->route('jasa.indexWeb')->with('success', 'Data jasa berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::alert('Gagal', 'Gagal mengupdate data Jasa!', 'error');
            return redirect()->route('barang.indexWeb');
            // return redirect()->route('jasa.indexWeb')->with('error', 'Data jasa gagal diperbarui.');
        }
    }

    public function destroy($idJasa)
    {
        $Jasa = Jasa::find($idJasa);

        if (!$Jasa) {
            return redirect()->route(route: 'jasa.indexWeb')->with('error', 'Data jasa tidak ditemukan.');
        }

        $Jasa->delete();
        Alert::alert('Berhasil', 'Berhasil menghapus data Jasa!', 'success');
        return redirect()->route('jasa.indexWeb');
        // return redirect()->route('jasa.indexWeb')->with('success', 'Data jasa berhasil dihapus.');
    }
}
