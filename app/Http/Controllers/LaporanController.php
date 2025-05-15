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

        $pendapatanHarian = Penjualan::selectRaw('DATE(created_at) as tanggal, SUM(totalHarga) as total')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();

        $totalPendapatanBulanIni = $pendapatanHarian->sum('total');

        return view('laporan.pendapatan-cetak', compact(
            'pendapatanHarian',
            'totalPendapatanBulanIni',
            'startOfMonth',
            'endOfMonth'
        ));
    }
}
