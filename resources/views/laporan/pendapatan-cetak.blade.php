<!DOCTYPE html>
<html>
<head>
  <title>Laporan Pendapatan Bulan Ini</title>
  <style>
    body { font-family: sans-serif; margin: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    table, th, td { border: 1px solid black; }
    th, td { padding: 8px; text-align: center; }
    h2 { text-align: center; }
    .total { font-weight: bold; background: #f2f2f2; }
    .text-right { text-align: right; }
  </style>
</head>
<body onload="window.print()">
  <h2>Laporan Pendapatan Bulan {{ \Carbon\Carbon::now()->format('F Y') }}</h2>
  <p>Periode: {{ $startOfMonth->format('d M Y') }} - {{ $endOfMonth->format('d M Y') }}</p>

  <table>
    <thead>
      <tr>
        <th>Tanggal</th>
        <th>Total Pendapatan (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pendapatanHarian as $data)
        <tr>
          <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d M Y') }}</td>
          <td class="text-right">{{ number_format($data->total, 0, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr class="total">
        <td>Total Pendapatan Bulan Ini</td>
        <td class="text-right">Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>
