<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produks = DB::table('produks')->get(['idProduk', 'harga'])->toArray();
        if (empty($produks)) {
            return;
        }

            $idPenjualanProduk = '2e930d49-1d9b-4a3f-a402-a28ecb073c4d';
            $idPenjualan = Str::uuid();
            $totalHarga = 0;
            $jumlahProduk = rand(1, 3);

            DB::table('penjualans')->insert([
                'idPenjualan' => $idPenjualan,
                'totalHarga' => 0,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $produkTerpilih = array_rand($produks, $jumlahProduk);
            if (!is_array($produkTerpilih)) {
                $produkTerpilih = [$produkTerpilih];
            }

            foreach ($produkTerpilih as $index) {
                $produk = $produks[$index];
                $idProduk = $produk->idProduk;
                $hargaProduk = $produk->harga;
                $kuantitas = rand(1, 5);
                $subTotal = $hargaProduk * $kuantitas;
                $totalHarga += $subTotal;

                DB::table('penjualanproduks')->insert([
                    'idPenjualanProduk' => $idPenjualanProduk,
                    'idPenjualan' => $idPenjualan,
                    'idProduk' => $idProduk,
                    'kuantitas' => $kuantitas,
                    'jumlah' => $subTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('penjualans')
                ->where('idPenjualan', $idPenjualan)
                ->update(['totalHarga' => $totalHarga]);
    }
}
