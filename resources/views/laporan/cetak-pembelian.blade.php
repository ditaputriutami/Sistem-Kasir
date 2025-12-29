<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
        }
        body {
            padding: 20px;
        }
        .header-laporan {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        .info-periode {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header-laporan">
        <h2>LAPORAN PEMBELIAN BARANG</h2>
        <p class="mb-0">Sistem Pembelian Barang</p>
    </div>

    @if($tanggalDari || $tanggalSampai)
    <div class="info-periode">
        <strong>Periode:</strong>
        @if($tanggalDari && $tanggalSampai)
            {{ date('d/m/Y', strtotime($tanggalDari)) }} s/d {{ date('d/m/Y', strtotime($tanggalSampai)) }}
        @elseif($tanggalDari)
            Dari {{ date('d/m/Y', strtotime($tanggalDari)) }}
        @elseif($tanggalSampai)
            Sampai {{ date('d/m/Y', strtotime($tanggalSampai)) }}
        @endif
    </div>
    @endif

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th width="5%">No</th>
                <th>No. Faktur</th>
                <th>Tanggal</th>
                <th>Pemasok</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $grandTotal = 0; @endphp
            @foreach($data as $beli)
                @foreach($beli->detailBeli as $detail)
                <tr>
                    @if($loop->first)
                    <td rowspan="{{ $beli->detailBeli->count() }}">{{ $no++ }}</td>
                    <td rowspan="{{ $beli->detailBeli->count() }}">{{ $beli->no_faktur }}</td>
                    <td rowspan="{{ $beli->detailBeli->count() }}">{{ $beli->tanggal->format('d/m/Y') }}</td>
                    <td rowspan="{{ $beli->detailBeli->count() }}">{{ $beli->pemasok->nama_pemasok }}</td>
                    @endif
                    <td>{{ $detail->barang->nama_barang }}</td>
                    <td>{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                    <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @php $grandTotal += $detail->subtotal; @endphp
                @endforeach
            @endforeach
        </tbody>
        <tfoot class="table-light">
            <tr>
                <th colspan="7" class="text-end">GRAND TOTAL:</th>
                <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="mt-4">
        <p><strong>Dicetak pada:</strong> {{ date('d F Y H:i:s') }}</p>
    </div>

    <div class="no-print mt-3">
        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <script>
        // Auto print saat halaman dimuat (opsional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
