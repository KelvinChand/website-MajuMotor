<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produkBarang = [
            ['nama' => 'Oli Mesin', 'harga' => 75000, 'jenis' => 'Oli', 'tipe' => 'Barang'],
            ['nama' => 'Busi', 'harga' => 25000, 'jenis' => 'Elektrik', 'tipe' => 'Barang'],
            ['nama' => 'Kampas Rem', 'harga' => 55000, 'jenis' => 'Rem', 'tipe' => 'Barang'],
            ['nama' => 'Aki Motor', 'harga' => 200000, 'jenis' => 'Elektrik', 'tipe' => 'Barang'],
            ['nama' => 'Filter Udara', 'harga' => 40000, 'jenis' => 'Filter', 'tipe' => 'Barang'],
        ];

        $produkJasa = [
            ['nama' => 'Ganti Oli', 'harga' => 30000, 'tipe' => 'Jasa'],
            ['nama' => 'Tune Up', 'harga' => 100000, 'tipe' => 'Jasa'],
            ['nama' => 'Service Rem', 'harga' => 80000, 'tipe' => 'Jasa'],
            ['nama' => 'Balancing Roda', 'harga' => 50000, 'tipe' => 'Jasa'],
            ['nama' => 'Cuci Motor', 'harga' => 20000, 'tipe' => 'Jasa'],
        ];

        foreach ($produkBarang as $index => $produk) {
            $idProduk = Str::uuid();

            DB::table('produks')->insert([
                'idProduk' => $idProduk,
                'nama' => $produk['nama'],
                'harga' => $produk['harga'],
                'tipe' => $produk['tipe'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($index < 5) {
                DB::table('barangs')->insert([
                    'idBarang' => Str::uuid(),
                    'idProduk' => $idProduk,
                    'stok' => rand(10, 50),
                    'jenis' => "Suku cadang",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        foreach ($produkJasa as $index => $produk) {
            $idProduk = Str::uuid();

            DB::table('produks')->insert([
                'idProduk' => $idProduk,
                'nama' => $produk['nama'],
                'harga' => $produk['harga'],
                'tipe' => $produk['tipe'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($index < 5) {
                DB::table('jasas')->insert([
                    'idJasa' => Str::uuid(),
                    'idProduk' => $idProduk,
                    'deskripsiKeluhan' => "Perawatan rutin",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
