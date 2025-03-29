@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Penjualan</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+&nbsp; Tambah Penjualan</a>
                    </div>
                </div>
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
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Aksi
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
                                                <td class="text-start" rowspan="{{ $totalRows }}">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <a href="#" class="btn bg-gradient-warning btn-sm mb-0 me-2 btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditBarang">
                                                            <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M16.862 3.487a1.5 1.5 0 0 1 2.121 0l1.53 1.53a1.5 1.5 0 0 1 0 2.12l-12.9 12.901-4.246.707a1 1 0 0 1-1.164-1.164l.707-4.246 12.952-12.95zM4.79 17.896l2.086.347 11.47-11.471-2.433-2.432L4.79 17.896zm-1.151 1.384l-.632 3.79 3.79-.632-3.158-3.158z" fill="#FFFFFF"/>
                                                            </svg> Edit
                                                        </a>
                                                        <form action="" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn bg-gradient-danger btn-sm mb-0 btn-hapus">
                                                                <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M3 6h18M9 6V4a3 3 0 0 1 6 0v2m2 0v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6h10z" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            <p class="text-xs font-weight-bold mb-0">Tidak ada data penjualan yang tersedia.</p>
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