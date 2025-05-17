<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            width: 300px;
        }
        .text-center {
            text-align: center;
        }
        .dashed {
            border-top: 1px dashed black;
            margin: 10px 0;
        }
        .double {
            border-top: 2px double black;
            margin: 10px 0;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        @media print {
        @page {
            size: 58mm auto; /* atau 80mm untuk kertas lebih lebar */
            margin: 0;
        }

        body {
            width: 58mm;
            margin: 0;
            font-size: 11px;
            font-family: monospace;
        }

        .text-center {
            text-align: center;
        }

        .row {
            display: flex;
            justify-content: space-between;
        }

        .dashed {
            border-top: 1px dashed #000;
            margin: 4px 0;
        }

        .double {
            border-top: 2px solid #000;
            margin: 6px 0;
        }
    }
    </style>
</head>
<body>
    <div class="text-center">
        <strong>TOKO MAJU MOTOR</strong><br>
        Jl. Raya Contoh No. 123<br>
        0812-3456-7890<br>
    </div>

    <div class="dashed"></div>

    <div>
        <div class="row">
            <span>No. Nota</span>
            <span>{{ $penjualan->idPenjualan ?? $penjualan->id }}</span>
        </div>
        <div class="row">
            <span>Tanggal</span>
            <span>{{ $penjualan->created_at->format('d-m-Y H:i') }}</span>
        </div>
    </div>

    <div class="double"></div>

    @forelse ($penjualan->penjualanProduk as $penjualanProduk)
        <div class="row">
            <span>{{ $penjualanProduk->produk->nama ?? 'Produk' }}</span>
            <span>Rp. {{ $penjualanProduk->jumlah }} x {{ number_format($penjualanProduk->kuantitas, 0, ',', '.') }}</span>
            <span class="text-right">Rp. {{ number_format($penjualanProduk->kuantitas * $penjualanProduk->jumlah, 0, ',', '.') }}</span>
        </div>
    @empty
        <div class="row text-center">
            Tidak ada produk.
        </div>
    @endforelse

    <div class="double"></div>

    <div class="row">
        <strong>Total</strong>
        <strong>Rp. {{ number_format($penjualan->totalHarga, 0, ',', '.') }}</strong>
    </div>

    <div class="dashed"></div>

    <div class="text-center">
        TERIMA KASIH<br>
        TELAH BERBELANJA
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
