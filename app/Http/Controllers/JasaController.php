<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;

class JasaController extends Controller
{
    public function index()
    {
        $Jasa = Jasa::all();
        return view('/', compact('Jasa'));
    }

    public function store($idProduk, $deskripsiKeluhan)
    {
        $attributes = request()->validate([
            'deskripsiKeluhan' => $deskripsiKeluhan,
            'idProduk' => $idProduk,
        ]);

        $Jasa = Jasa::create($attributes);

        if (!$Jasa) {
            return response()->json(['message' => 'Gagal Menyimpan Data Jasa'], 500);
        }

        return response()->json(['message' => 'Data Jasa Berhasil Dibuat', 'Jasa' => $Jasa], 201);
    }

    public function update(Request $request, $id)
    {
        $Jasa = Jasa::find($id);

        if (!$Jasa) {
            return response()->json(['message' => 'Jasa Tidak Ditemukan'], 404);
        }

        $attributes = $request->validate([
            'deskripsiKeluhan' => ['string'],
        ]);

        $Jasa->update($attributes);

        return response()->json(['message' => 'Data Jasa Berhasil Diperbarui', 'Jasa' => $Jasa], 200);
    }

    public function destroy($id)
    {
        $Jasa = Jasa::find($id);

        if (!$Jasa) {
            return response()->json(['message' => 'Jasa Tidak Ditemukan'], 404);
        }

        $Jasa->delete();
        return response()->json(['message' => 'Data Jasa Berhasil Dihapus'], 200);
    }
}
