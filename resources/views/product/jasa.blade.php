@extends('layouts.user_type.auth')

@section('content')
    <div>
        <div class="row">
            <div class="col-12">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-4" role="alert">
                        <span class="text-xs text-white">{{ session('success') }}</span>
                        <button type="button" class="btn-close text-danger d-flex align-items-center justify-content-center"
                            data-bs-dismiss="alert" aria-label="Close">
                            <span class="text-danger" style="font-size: 20px;" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mx-4" role="alert">
                        <span class="text-xs text-white">{{ session('error') }}</span>
                        <button type="button" class="btn-close text-danger d-flex align-items-center justify-content-center"
                            data-bs-dismiss="alert" aria-label="Close">
                            <span class="text-danger" style="font-size: 20px;" aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif



                <div class="card mb-4 mx-4">
                    <div class="card-header pb-0 mb-4">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h6 class="mb-0">Daftar Jasa</h6>
                            </div>
                            <a href="#" class="btn bg-gradient-primary btn-sm mb-0 me-2" type="button"
                                data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                                <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5v14M5 12h14" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg> Tambah Jasa
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
                                            Nama Jasa
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Harga Jasa
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Deskripsi Keluhan
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>
                                <tbody>
                                    @forelse ($jasa as $index => $item)
                                        <tr>
                                            <td class="ps-4" style="max-width: 200px">
                                                <p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p>
                                            </td>
                                            <td class="text-start" style="min-width: 200px">
                                                <p class="text-xs font-weight-bold mb-0" style="min-width: 200px">
                                                    {{ $item->produk->nama }}
                                                </p>
                                            </td>
                                            <td class="text-start" style="min-width: 200px">
                                                <p class="text-xs font-weight-bold mb-0" style="min-width: 200px">Rp.
                                                    {{ number_format($item->produk->harga, 0, ',', '.') }}
                                                </p>
                                            </td>
                                            <td class="text-start"
                                                style="max-width: 400px; word-wrap: break-word; overflow-wrap: break-word;">
                                                <p class="text-xs font-weight-bold mb-0"
                                                    style="max-width: 400px; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; text-align: justify;">
                                                    {{ $item->deskripsiKeluhan }}
                                                </p>
                                            </td>

                                            <td class="text-start">
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="#" class="btn bg-gradient-warning btn-sm mb-0 me-2 btn-edit"
                                                        data-id="{{ $item->produk->jasa->idJasa }}"
                                                        data-nama="{{ $item->produk->nama }}"
                                                        data-harga="{{ $item->produk->harga }}"
                                                        data-deskripsiKeluhan="{{ $item->deskripsiKeluhan }}"
                                                        data-bs-toggle="modal" data-bs-target="#modalEditBarang">
                                                        <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M16.862 3.487a1.5 1.5 0 0 1 2.121 0l1.53 1.53a1.5 1.5 0 0 1 0 2.12l-12.9 12.901-4.246.707a1 1 0 0 1-1.164-1.164l.707-4.246 12.952-12.95zM4.79 17.896l2.086.347 11.47-11.471-2.433-2.432L4.79 17.896zm-1.151 1.384l-.632 3.79 3.79-.632-3.158-3.158z"
                                                                fill="#FFFFFF" />
                                                        </svg> Edit
                                                    </a>
                                                    <form action="{{ route('jasa.delete', $item->produk->jasa->idJasa) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn bg-gradient-danger btn-sm mb-0 btn-hapus"
                                                            data-id="{{ $item->produk->jasa->idJasa }}">
                                                            <svg width="12px" height="12px" viewBox="0 0 24 24" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M3 6h18M9 6V4a3 3 0 0 1 6 0v2m2 0v14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6h10z"
                                                                    stroke="#FFFFFF" stroke-width="2" stroke-linecap="round"
                                                                    stroke-linejoin="round" />
                                                            </svg> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    Tidak ada data barang yang tersedia.
                                                </p>
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

    <!-- Modal Edit Barang -->
    <div class="modal fade" id="modalEditBarang" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditJasa" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editIdBarang" name="idBarang">

                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editHarga" class="form-label">Harga Barang</label>
                            <input type="number" class="form-control" id="editHarga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDeskripsiKeluhan" class="form-label">Deskripsi Keluhan</label>
                            <input type="text" class="form-control" id="editDeskripsiKeluhan" name="deskripsiKeluhan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Tambah Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('jasa.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Jasa</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Jasa</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsiKeluhan" class="form-label">Deskripsi Keluhan</label>
                            <input type="text" class="form-control" id="deskripsiKeluhan" name="deskripsiKeluhan">
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
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.btn-edit').forEach(button => {
                button.addEventListener('click', function () {
                    let id = this.getAttribute('data-id');
                    let nama = this.getAttribute('data-nama');
                    let harga = this.getAttribute('data-harga');
                    let deskripsiKeluhan = this.getAttribute('data-deskripsiKeluhan');

                    document.getElementById('editIdBarang').value = id;
                    document.getElementById('editNama').value = nama;
                    document.getElementById('editHarga').value = harga;
                    document.getElementById('editDeskripsiKeluhan').value = deskripsiKeluhan;

                    // Set form action dynamically
                    document.getElementById('formEditJasa').action = `/jasa/${id}/update`;
                });
            });
        });
    </script>

@endsection