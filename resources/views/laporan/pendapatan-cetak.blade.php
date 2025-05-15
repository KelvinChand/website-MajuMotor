<!DOCTYPE html>
<html>
<head>
  <title>Laporan Pendapatan Bulan {{ \Carbon\Carbon::now()->format('F Y') }}</title>
  <style>
    body { font-family: sans-serif; margin: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 8px; text-align: center; }
    h2 { text-align: center; margin-bottom: 5px; }
    p { text-align: center; margin-top: 0; }
    .total-row { background-color: #f2f2f2; font-weight: bold; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
  </style>
</head>
<body onload="window.print()">
  <h2>Laporan Pendapatan Bulan {{ \Carbon\Carbon::now()->format('F Y') }}</h2>
  <p>Periode: {{ $startOfMonth->format('d M Y') }} - {{ $endOfMonth->format('d M Y') }}</p>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Produk</th>
        <th>Harga Produk</th>
        <th>Jumlah</th>
        <th>Total Produk</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach ($pendapatanPerTanggal as $tanggal => $data)
        @foreach ($data['details'] as $item)
          <tr>
            <td>{{ $no++ }}</td>
            <td>{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</td>
            <td class="text-left">{{ $item['nama_produk'] }}</td>
            <td class="text-right">Rp {{ number_format($item['harga_produk'], 0, ',', '.') }}</td>
            <td>{{ $item['jumlah_produk'] }}</td>
            <td class="text-right">Rp {{ number_format($item['total_produk'], 0, ',', '.') }}</td>
          </tr>
        @endforeach
        <tr class="total-row">
          <td colspan="5" class="text-right">Total Pendapatan Tanggal {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</td>
          <td class="text-right">Rp {{ number_format($data['total_transaksi'], 0, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr class="total-row">
        <td colspan="5" class="text-right">Total Pendapatan Bulan Ini</td>
        <td class="text-right">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>
