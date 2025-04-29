<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Barang;
use App\Models\Jasa;
use App\Models\PenjualanProduk;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenjualanController extends Controller
{
    public function index()
    {
        $Penjualan = Penjualan::with('penjualanProduk.produk')
            ->whereNotIn('status', ['selesai', 'gagal'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Pastikan $jasa dan $barang tetap didefinisikan meskipun $Penjualan kosong
        $jasa = Jasa::with('produk')->get();
        $barang = Barang::with('produk')->get();

        return view('jual.penjualan', compact('Penjualan', 'jasa', 'barang'));
    }


    public function store(Request $request)
    {
        $attributes = $request->validate([
            'items' => ['required', 'array'],
            'items.*.idProduk' => ['required', 'string'],
            'items.*.kuantitas' => ['required', 'integer', 'min:1'],
        ]);

        DB::beginTransaction();
        try {
            $status = 'pending';
            $totalHarga = 0;

            // Simpan data penjualan terlebih dahulu
            $penjualan = Penjualan::create([
                'status' => $status,
                'totalHarga' => 0, // Sementara 0, akan diperbarui nanti
            ]);

            foreach ($attributes['items'] as $item) {
                $produk = Produk::findOrFail($item['idProduk']); // Pastikan produk ditemukan
                $subTotal = $produk->harga * $item['kuantitas'];
                $totalHarga += $subTotal;

                $barang = Barang::where('idProduk', $item['idProduk'])->first();

                // Jika produk ada di tabel Barang, cek stok
                if ($barang) {
                    if ($barang->stok < $item['kuantitas']) {
                        DB::rollBack();
                        return response()->json([
                            'message' => "Stok tidak mencukupi untuk produk {$produk->nama}",
                        ], 400);
                    }
                    $barang->decrement('stok', $item['kuantitas']);
                }

                // Simpan ke tabel PenjualanProduk
                PenjualanProduk::create([
                    'idPenjualan' => $penjualan->idPenjualan,
                    'idProduk' => $item['idProduk'],
                    'jumlah' => $subTotal, // Tetap menggunakan 'jumlah' seperti di DB
                    'kuantitas' => $item['kuantitas'],
                ]);
            }

            // Perbarui total harga di tabel Penjualan
            $penjualan->update(['totalHarga' => $totalHarga]);

            DB::commit();
            Alert::alert('Berhasil', 'Berhasil membuat data Penjualan!', 'success');
            // return redirect()->route('penjualan.index');
            return response()->json([
                'success' => true,
                'message' => 'Data penjualan berhasil disimpan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Data penjualan gagal disimpan.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // public function updateStatus(Request $request, $idPenjualan)
    // {
    //     $penjualan = Penjualan::find($idPenjualan);

    //     if (!$penjualan) {
    //         return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
    //     }

    //     $attributes = $request->validate([
    //         'status' => ['required', 'in:pending,perbaikan,selesai,gagal']
    //     ]);

    //     try {
    //         $penjualan->update(['status' => $attributes['status']]);
    //         return redirect()->route('penjualan.index')->with('success', 'Status penjualan berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         return redirect()->route('penjualan.index')->with('error', 'Terjadi kesalahan saat memperbarui status penjualan: ' . $e->getMessage());
    //     }
    // }

    public function updateStatus(Request $request, $idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);

        if (!$penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
        }

        // Debug: Cek data yang diterima dari form
        // dd($request->all());

        $attributes = $request->validate([
            'status' => ['required', 'in:pending,perbaikan,selesai,gagal']
        ]);

        if ($penjualan->status == 'gagal' && $attributes['status'] == 'gagal') {
            return response()->json(['message' => 'Penjualan sudah berstatus gagal'], 400);
        }

        if ($attributes['status'] == 'gagal') {
            $dataPenjualan = PenjualanProduk::where('idPenjualan', $idPenjualan)->get();

            foreach ($dataPenjualan as $item) {
                $barang = Barang::where('idProduk', $item->idProduk)->first();
                if ($barang) {
                    $barang->stok += $item->kuantitas;
                    $barang->save();
                } else {
                    continue;
                }
            }
        }

        try {
            $penjualan->update(['status' => $attributes['status']]);
            Alert::alert('Berhasil', 'Status penjualan berhasil diperbarui.', 'success');
            return redirect()->route('penjualan.index');
            // return redirect()->route('penjualan.index')->with('success', 'Status penjualan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('penjualan.index')->with('error', 'Terjadi kesalahan saat memperbarui status penjualan: ' . $e->getMessage());
        }
    }


    public function destroy($idPenjualan)
    {
        $penjualan = Penjualan::find($idPenjualan);
        if (!$penjualan) {
            return redirect()->route('penjualan.index')->with('error', 'Data penjualan tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            $dataPenjualan = PenjualanProduk::where('idPenjualan', $idPenjualan)->get();
            foreach ($dataPenjualan as $item) {
                $barang = Barang::where('idProduk', $item->idProduk)->first();
                if ($barang) {
                    $barang->stok += $item->kuantitas;
                    $barang->save();
                } else {
                    continue;
                }
            }
            PenjualanProduk::where('idPenjualan', $idPenjualan)->delete();
            $penjualan->delete();

            DB::commit();

            Alert::alert('Berhasil', 'Data penjualan berhasil dihapus.', 'success');
            return redirect()->route('penjualan.index');
            // return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('penjualan.index')->with('error', 'Terjadi kesalahan saat menghapus data penjualan: ' . $e->getMessage());
        }
    }
}
