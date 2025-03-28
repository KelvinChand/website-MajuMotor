<?php

namespace App\Http\Controllers;

use App\Models\Jasa;
use Illuminate\Http\Request;

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

    // public function update(Request $request, $idJasa)
    // {
    //     $Jasa = Jasa::find($idJasa);

    //     if (!$Jasa) {
    //         return response()->json(['message' => 'Jasa Tidak Ditemukan'], 404);
    //     }

    //     $attributes = $request->validate([
    //         'deskripsiKeluhan' => ['string'],
    //     ]);

    //     $Jasa->update($attributes);

    //     return response()->json(['message' => 'Data Jasa Berhasil Diperbarui', 'Jasa' => $Jasa], 200);
    // }

    // public function destroy($idJasa)
    // {
    //     $Jasa = Jasa::find($idJasa);

    //     if (!$Jasa) {
    //         return response()->json(['message' => 'Jasa Tidak Ditemukan'], 404);
    //     }

    //     $Jasa->delete();
    //     return response()->json(['message' => 'Data Jasa Berhasil Dihapus'], 200);
    // }
}
