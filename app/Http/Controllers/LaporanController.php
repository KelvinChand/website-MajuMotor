<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;

class LaporanController extends Controller
{
    public function cetakPendapatan()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Ambil semua penjualan selesai pada bulan ini beserta relasi produknya
        $penjualans = Penjualan::with('penjualanProduk.produk')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->orderBy('created_at')
            ->get();

        // Format ulang data agar bisa dikelompokkan per tanggal
        $pendapatanPerTanggal = [];

        foreach ($penjualans as $penjualan) {
            $tanggal = $penjualan->created_at->format('Y-m-d');

            // Siapkan array tanggal jika belum ada
            if (!isset($pendapatanPerTanggal[$tanggal])) {
                $pendapatanPerTanggal[$tanggal] = [
                    'tanggal' => $tanggal,
                    'details' => [],
                    'total_transaksi' => 0
                ];
            }

            foreach ($penjualan->penjualanProduk as $item) {
                $namaProduk = $item->produk->nama ?? 'Produk Tidak Ditemukan';
                $harga = $item->produk->harga;
                $jumlah = $item->kuantitas;
                $totalPerItem = $harga * $jumlah;

                $pendapatanPerTanggal[$tanggal]['details'][] = [
                    'nama_produk' => $namaProduk,
                    'harga_produk' => $harga,
                    'jumlah_produk' => $jumlah,
                    'total_produk' => $totalPerItem
                ];

                $pendapatanPerTanggal[$tanggal]['total_transaksi'] += $totalPerItem;
            }
        }

        // Hitung total pendapatan keseluruhan bulan ini
        $totalPendapatanBulanIni = array_sum(array_column($pendapatanPerTanggal, 'total_transaksi'));

        return view('laporan.pendapatan-cetak', [
            'pendapatanPerTanggal' => $pendapatanPerTanggal,
            'totalPendapatanBulanIni' => $totalPendapatanBulanIni,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth
        ]);
    }
}
