@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Produk
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Tipe
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Harga Produk
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Jumlah Produk
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Total Harga Produk
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Total Harga
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status
                                    </th>
                                </tr>

                            </thead>
                            <tbody>
                                @forelse ($Penjualan as $index => $item)
                                    @php
                                        $totalRows = $item->penjualanProduk->count(); // Hitung jumlah item dalam transaksi
                                    @endphp
                            
                                    @foreach ($item->penjualanProduk as $i => $penjualanProduk)
                                        <tr>
                                            @if ($i == 0)
                                                <td class="ps-4 text-center" rowspan="{{ $totalRows }}">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                                </td>
                                            @endif
                            
                                            {{-- Nama Produk --}}
                                            <td class="text-start" style="min-width: 200px; border-bottom: 1px solid #ddd;" >
                                                <p class="text-xs font-weight-bold mb-0">{{ $penjualanProduk->produk->nama ?? 'Produk Tidak Ditemukan' }}</p>
                                            </td>

                                            <td class="text-start" style="min-width: 200px; border-bottom: 1px solid #ddd;" >
                                                <p class="text-xs font-weight-bold mb-0">{{ $penjualanProduk->produk->tipe ?? 'Produk Tidak Ditemukan' }}</p>
                                            </td>

                                            {{-- Harga Produk --}}
                                            <td class="text-start" style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                <p class="text-xs font-weight-bold mb-0">Rp. {{ number_format($penjualanProduk->produk->harga, 0, ',', '.') }}</p>
                                            </td>
                                            
                                            {{-- Kuantitas Produk --}}
                                            <td class="text-start" style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                <p class="text-xs font-weight-bold mb-0">{{ $penjualanProduk->kuantitas ?? 'Produk Tidak Ditemukan' }}</p>
                                            </td>

                                            {{-- Total Harga Produk --}}
                                            <td class="text-start" style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                <p class="text-xs font-weight-bold mb-0">Rp. {{ number_format($penjualanProduk->jumlah, 0, ',', '.') }}</p>
                                            </td>
                            
                                            @if ($i == 0)
                                                <td class="text-start" rowspan="{{ $totalRows }}">
                                                    <p class="text-xs font-weight-bold mb-0">Rp. {{ number_format($item->totalHarga, 0, ',', '.') }}</p>
                                                </td>
                                                <td class="text-start" rowspan="{{ $totalRows }}">
                                                    @if ($item->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif ($item->status == 'perbaikan')
                                                        <span class="badge bg-primary">Sedang Diperbaiki</span>
                                                    @elseif ($item->status == 'selesai')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif ($item->status == 'gagal')
                                                        <span class="badge bg-danger">Gagal</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <p class="text-xs font-weight-bold mb-0">Tidak ada riwayat penjualan yang tersedia.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection