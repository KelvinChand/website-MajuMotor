@extends('layouts.user_type.auth')

@section('content')

    <div>
        <div class="row">
            <div class="col-12">

                <div id="alert-container">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                            <span class="text-xs text-white">{{ session('success') }}</span>
                            <button type="button"
                                class="btn-close text-danger d-flex align-items-center justify-content-center"
                                data-bs-dismiss="alert" aria-label="Close">
                                <span class="text-danger" style="font-size: 20px;" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                            <span class="text-xs text-white">{{ session('error') }}</span>
                            <button type="button"
                                class="btn-close text-danger d-flex align-items-center justify-content-center"
                                data-bs-dismiss="alert" aria-label="Close">
                                <span class="text-danger" style="font-size: 20px;" aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card mb-4 mx-4">
                    <div class="card-header pb-4">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h6 class="mb-0">Penjualan</h6>
                            </div>
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-0 me-2" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalTambahPenjualan">
                                <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5v14M5 12h14" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg> Tambah Penjualan
                            </a>
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
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @forelse ($Penjualan as $index => $item)
                                        @php
                                            $totalRows = $item->penjualanProduk->count();
                                        @endphp



                                        @foreach ($item->penjualanProduk as $i => $penjualanProduk)
                                            <tr>
                                                @if ($i === 0)
                                                    <td class="ps-4 text-center" rowspan="{{ $totalRows }}">
                                                        <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                                    </td>
                                                @endif

                                                <td class="text-start"
                                                    style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $penjualanProduk->produk->nama ?? 'Produk Tidak Ditemukan' }}
                                                    </p>
                                                </td>

                                                <td class="text-start"
                                                    style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $penjualanProduk->produk->tipe ?? 'Produk Tidak Ditemukan' }}
                                                    </p>
                                                </td>

                                                <td class="text-start"
                                                    style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                    <p class="text-xs font-weight-bold mb-0">Rp.
                                                        {{ number_format($penjualanProduk->produk->harga ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </td>

                                                <td class="text-start"
                                                    style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        {{ $penjualanProduk->kuantitas ?? 0 }}
                                                    </p>
                                                </td>

                                                <td class="text-start"
                                                    style="min-width: 200px; border-bottom: 1px solid #ddd;">
                                                    <p class="text-xs font-weight-bold mb-0">Rp.
                                                        {{ number_format($penjualanProduk->jumlah ?? 0, 0, ',', '.') }}
                                                    </p>
                                                </td>

                                                @if ($i === 0)
                                                    <td class="text-start" rowspan="{{ $totalRows }}">
                                                        <p class="text-xs font-weight-bold mb-0">Rp.
                                                            {{ number_format($item->totalHarga ?? 0, 0, ',', '.') }}
                                                        </p>
                                                    </td>
                                                    {{-- <td class="text-start" rowspan="{{ $totalRows }}">
                                                                                                                                @php
                                                                                                                                $statusBadge = [
                                                                                                                                'pending' => 'bg-warning text-dark',
                                                                                                                                'perbaikan' => 'bg-primary',
                                                                                                                                'selesai' => 'bg-success',
                                                                                                                                'gagal' => 'bg-danger',
                                                                                                                                ];
                                                                                                                                $statusText = [
                                                                                                                                'pending' => 'Pending',
                                                                                                                                'perbaikan' => 'Sedang Diperbaiki',
                                                                                                                                'selesai' => 'Selesai',
                                                                                                                                'gagal' => 'Gagal',
                                                                                                                                ];
                                                                                                                                $statusClass = $statusBadge[$item->status] ?? 'bg-secondary';
                                                                                                                                $statusLabel = $statusText[$item->status] ?? 'Unknown';
                                                                                                                                @endphp
                                                                                                                                <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                                                                                                            </td> --}}
                                                    <td class="text-start" rowspan="{{ $totalRows }}"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditStatus">
                                                        @php
                                                            $statusBadge = [
                                                                'pending' => 'bg-warning text-dark',
                                                                'perbaikan' => 'bg-primary',
                                                                'selesai' => 'bg-success',
                                                                'gagal' => 'bg-danger',
                                                            ];
                                                            $statusText = [
                                                                'pending' => 'Pending',
                                                                'perbaikan' => 'Sedang Diperbaiki',
                                                                'selesai' => 'Selesai',
                                                                'gagal' => 'Gagal',
                                                            ];
                                                            $statusClass =
                                                                $statusBadge[$item->status] ?? 'bg-secondary';
                                                            $statusLabel = $statusText[$item->status] ?? 'Unknown';
                                                        @endphp
                                                        <span class="badge {{ $statusClass }}" style="cursor: pointer;">
                                                            {{ $statusLabel }}
                                                        </span>
                                                    </td>



                                                    <td class="text-start" rowspan="{{ $totalRows }}">
                                                        <div class="d-flex align-items-center gap-2">
                                                            {{-- <a href="#" class="btn bg-gradient-warning btn-sm mb-0 me-2 btn-edit"
                                                                                                                                        data-bs-toggle="modal" data-bs-target="#modalEditBarang">
                                                                                                                                        <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none"
                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                            <path
                                                                                                                                                d="M16.862 3.487a1.5 1.5 0 0 1 2.121 0l1.53 1.53a1.5 1.5 0 0 1 0 2.12l-12.9 12.901-4.246.707a1 1 0 0 1-1.164-1.164l.707-4.246 12.952-12.95zM4.79 17.896l2.086.347 11.47-11.471-2.433-2.432L4.79 17.896zm-1.151 1.384l-.632 3.79 3.79-.632-3.158-3.158z"
                                                                                                                                                fill="#FFFFFF" />
                                                                                                                                        </svg> Edit
                                                                                                                                    </a> --}}
                                                            <form
                                                                action="{{ route('penjualan.destroy', $penjualanProduk->idPenjualan) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn bg-gradient-danger btn-sm mb-0 btn-hapus"
                                                                    data-id="{{ $penjualanProduk->idPenjualan }}">
                                                                    <svg width="12px" height="12px" viewBox="0 0 24 24"
                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path
                                                                            d="M3 6h18M9 6V4a3 3 0 0 1 6 0v2m2 0v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6h10z"
                                                                            stroke="#FFFFFF" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" />
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
                                            <td colspan="9" class="text-center text-muted">
                                                <p class="text-xs  mb-0">Tidak ada data penjualan yang tersedia.</p>
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

    {{-- Modal edit status --}}
    @if (!empty($penjualanProduk))
        <div class="modal fade" id="modalEditStatus" tabindex="-1" aria-labelledby="modalEditStatusLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modalEditStatusLabel">Edit Status</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditStatus" method="POST"
                            action="{{ route('penjualan.updateStatus', $penjualanProduk->idPenjualan ?? '') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="idPenjualan" name="idPenjualan"
                                value="{{ $penjualanProduk->idPenjualan ?? '' }}">

                            <!-- Ubah name agar sesuai dengan controller -->
                            <input type="hidden" id="selectedStatusInput" name="status">

                            <div class="mb-3">
                                <label for="statusSelect" class="form-label">Pilih Status</label>
                                <select class="form-select" id="statusSelect">
                                    <option value="pending">Pending</option>
                                    <option value="perbaikan">Sedang Diperbaiki</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="gagal">Gagal</option>
                                </select>
                            </div>

                            <div class="d-flex w-100 align-items-end justify-content-end">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Modal Tambah Penjualan -->
    <div class="modal fade" id="modalTambahPenjualan" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modalLabel">Tambah Penjualan</h6>
                    <button type="button" class="btn-close text-danger d-flex align-items-center justify-content-center"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span class="text-danger" style="font-size: 20px;" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formDataPenjualan" action="{{ route('penjualan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="produk_id_barang" class="form-label">Produk Barang</label>
                            <div class="d-flex gap-2">
                                <select class="form-control" id="produk_id_barang" name="produk_id"
                                    style="height: 38px;">
                                    <option value="" disabled selected>Pilih Produk Barang</option>
                                    @foreach ($barang as $item)
                                        <option value="{{ $item->produk->barang->idBarang }}"
                                            data-id="{{ $item->produk->idProduk }}"
                                            data-nama="{{ $item->produk->nama }}"
                                            data-harga="{{ $item->produk->harga }}">
                                            {{ $item->produk->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                <div>
                                    <input type="number" class="form-control" id="insertQuantityBarang" name="quantity"
                                        placeholder="Kuantitas">
                                </div>
                                <button type="button" class="btn btn-secondary d-flex align-items-center"
                                    style="height: 38px;" id="tambahBarang">
                                    Tambah
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="tabel-barang">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Barang
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Satuan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kuantitas
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Barang
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="mb-2">
                            <label for="produk_id_jasa" class="form-label">Produk Jasa</label>
                            <div class="d-flex gap-2">
                                <select class="form-control" id="produk_id_jasa" name="produk_id" style="height: 38px;">
                                    <option value="" disabled selected>Pilih Produk Jasa</option>
                                    @foreach ($jasa as $item)
                                        <option value="{{ $item->produk->jasa->idJasa }}"
                                            data-id="{{ $item->produk->idProduk }}"
                                            data-nama="{{ $item->produk->nama }}"
                                            data-harga="{{ $item->produk->harga }}">
                                            {{ $item->produk->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                <div>
                                    <input type="number" class="form-control" id="insertQuantityJasa" name="quantity"
                                        placeholder="Kuantitas">
                                </div>
                                <button type="button" class="btn btn-secondary d-flex align-items-center"
                                    style="height: 38px;" id="tambahJasa">
                                    Tambah
                                </button>
                            </div>
                        </div>


                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="tabel-jasa">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nama Jasa
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Satuan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Kuantitas
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Jasa
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aksi
                                        </th>

                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>


                        {{-- Total Harga Barang + Jasa --}}
                        <div class="mb-2 mt-4 text-center">
                            <p class="text-xs font-weight-bold mb-0">
                                Total Harga Barang + Jasa: <br /><br />
                                <span id="totalHarga">Rp. 0</span>
                            </p>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            event.preventDefault();
            let totalHarga = 0;
            let data = [];

            const form = document.getElementById("formDataPenjualan");

            function updateTotalHarga() {
                let total = 0;
                document.querySelectorAll("[data-harga-total]").forEach(item => {
                    total += parseFloat(item.getAttribute("data-harga-total")) || 0;
                });
                document.getElementById("totalHarga").textContent = "Rp. " + total.toLocaleString("id-ID");
            }

            function tambahData(tipe) {
                let select = document.getElementById(tipe === "barang" ? "produk_id_barang" : "produk_id_jasa");
                let quantityInput = document.getElementById(tipe === "barang" ? "insertQuantityBarang" :
                    "insertQuantityJasa");

                if (!select || !quantityInput) {
                    console.error(`Elemen untuk ${tipe} tidak ditemukan.`);
                    return;
                }

                let kuantitas = parseInt(quantityInput.value);
                let selectedOption = select.options[select.selectedIndex];

                if (!selectedOption.value || isNaN(kuantitas) || kuantitas <= 0) {
                    alert("Harap pilih produk/jasa dan masukkan kuantitas yang benar!");
                    return;
                }

                let idProduk = selectedOption.getAttribute("data-id");
                let nama = selectedOption.getAttribute("data-nama");
                let harga = parseFloat(selectedOption.getAttribute("data-harga"));
                let hargaQuantity = harga * kuantitas;

                let tabelBody = document.querySelector(`#tabel-${tipe} tbody`);
                let row = document.createElement("tr");

                row.innerHTML =
                    `<td class="text-center" style="min-width: 50px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-xs font-weight-bold mb-0" style="min-width: 50px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ${tabelBody.children.length + 1}
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="text-start" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-xs font-weight-bold mb-0" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ${nama}
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="text-start" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-xs font-weight-bold mb-0" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                Rp. ${harga.toLocaleString("id-ID")}
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="text-start" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-xs font-weight-bold mb-0" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                ${kuantitas}
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td class="text-start" style="min-width: 200px">
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <p class="text-xs font-weight-bold mb-0 harga-total" style="min-width: 200px" data-harga-total="${hargaQuantity}">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                Rp. ${hargaQuantity.toLocaleString("id-ID")}
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </p>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                            <button type="button" class="btn bg-gradient-danger btn-sm mb-0 btn-hapus" onclick="hapusData(this, '${tipe}', '${idProduk}', ${hargaQuantity})">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <path d="M3 6h18M9 6V4a3 3 0 0 1 6 0v2m2 0v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6h10z" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </svg> Hapus
                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                        </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                    `;
                tabelBody.appendChild(row);

                // Tambahkan ke array
                if (tipe === "barang") {
                    data.push({
                        idProduk,
                        kuantitas
                    });
                } else {
                    data.push({
                        idProduk,
                        kuantitas
                    });
                }

                totalHarga += hargaQuantity;
                updateTotalHarga();

                // Reset input setelah ditambahkan
                quantityInput.value = "";
                select.selectedIndex = 0;


                console.log('Data', data)
            }

            window.hapusData = function(button, tipe, id, hargaQuantity) {
                button.closest("tr").remove();
                totalHarga -= hargaQuantity;
                updateTotalHarga();

                // Hapus dari array dengan id yang benar
                data = data.filter(item => item.idProduk != id);
            };


            document.getElementById("tambahBarang").addEventListener("click", function() {
                tambahData("barang");
            });

            document.getElementById("tambahJasa").addEventListener("click", function() {
                tambahData("jasa");
            });

            form.addEventListener("submit", function(event) {
                event.preventDefault(); // Pastikan form tidak melakukan reload

                if (data.length === 0) {
                    alert("Tambahkan setidaknya satu produk atau jasa.");
                    return;
                }

                console.log('Data sebelum dikirim', data);

                fetch("{{ route('penjualan.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        body: JSON.stringify({
                            items: data
                        })
                    })
                    .then(response => response.json())
                    .then(responseData => {
                        // console.log("Parsed Response:", responseData);
                        if (responseData.success) {
                            // alert("Data berhasil disimpan!");
                            // location.reload();
                        } else {
                            alert("Gagal menyimpan data.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Terjadi kesalahan saat menyimpan data.");
                    });
            });


        });
    </script>

    <script>
        document.getElementById('statusSelect').addEventListener('change', function() {
            document.getElementById('selectedStatusInput').value = this.value;
        });


        document.getElementById('formEditStatus').addEventListener('submit', function(event) {
            const selectedStatus = document.getElementById('selectedStatusInput').value;
            if (!selectedStatus) {
                alert('Silakan pilih status terlebih dahulu!');
                event.preventDefault();
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".btn-hapus").forEach(button => {
                button.addEventListener("click", function(event) {
                    event.preventDefault();
                    let form = this.closest("form");

                    Swal.fire({
                        title: "Apakah Anda yakin?",
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

@endsection
