<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\PenjualanProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::all();
        return view('/', compact('Penjualan'));
    }
    public function show($idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);

        if (!$penjualan) {
            return response()->json(['message' => 'Data Penjualan Tidak Ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail Data Penjualan',
            'Penjualan' => $penjualan
        ], 200);
    }

    public function store(Request $request)
    {
        $attributes = request()->validate(rules: [
            'data' => ['required', 'array'],
            'data.*.idProduk' => ['required', 'string'],
            'data.*.kuantitas' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'string', 'in:pending'],
            'totalHarga' => ['sometimes', 'numeric', 'in:0'],
        ]);

        DB::beginTransaction();
        try {

            $totalHarga = $attributes['totalHarga'] ??= 0;
            $penjualan = Penjualan::create(attributes: [
                'status' => $attributes['status'],
                'totalHarga' => $totalHarga,
            ]);



            foreach ($attributes['data'] as $item) {
                $produk = Produk::findOrFail(id: $item['idProduk']);
                $subTotal = $produk->harga * $item['kuantitas'];
                $totalHarga += $subTotal;
                PenjualanProduk::create([
                    'idPenjualan' => $penjualan->idPenjualan,
                    'idProduk' => $item['idProduk'],
                    'jumlah' => $subTotal,
                    'kuantitas' => $item['kuantitas'],
                ]);
            }
            $penjualan->update(['totalHarga' => $totalHarga]);

            DB::commit();
            return response()->json([
                'message' => 'Data Penjualan Berhasil Dibuat',
                'Penjualan' => $penjualan
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal Menyimpan Data Penjualan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
