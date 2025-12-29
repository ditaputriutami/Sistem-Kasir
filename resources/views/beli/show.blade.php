@extends('layouts.app')

@section('title', 'Detail Transaksi Pembelian')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-file-earmark-text"></i> Detail Transaksi Pembelian</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('beli.index') }}">Transaksi Pembelian</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Informasi Transaksi
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">No. Faktur</th>
                                <td><span class="badge bg-primary">{{ $beli->no_faktur }}</span></td>
                            </tr>
                            <tr>
                                <th>Tanggal</th>
                                <td>{{ $beli->tanggal->format('d F Y') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Pemasok</th>
                                <td>{{ $beli->pemasok->nama_pemasok }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td><strong class="text-primary">Rp {{ number_format($beli->total, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="bi bi-list-ul"></i> Detail Barang
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Barang</th>
                                <th width="15%">Jumlah</th>
                                <th width="20%">Harga Beli</th>
                                <th width="20%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($beli->detailBeli as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->barang->nama_barang }}</td>
                                <td>{{ $detail->jumlah }} {{ $detail->barang->satuan }}</td>
                                <td>Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="4" class="text-end">TOTAL:</th>
                                <th>Rp {{ number_format($beli->total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-gear"></i> Aksi
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('beli.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-info">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <i class="bi bi-check-circle"></i> Status Stok
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <i class="bi bi-info-circle"></i> Stok barang telah ditambahkan saat transaksi ini disimpan.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .btn, .card-header, nav { display: none !important; }
        .card { border: none !important; box-shadow: none !important; }
    }
</style>
@endsection
