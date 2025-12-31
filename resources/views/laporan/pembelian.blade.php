@extends('layouts.app')

@section('title', 'Laporan Pembelian')

@section('content')
<div class="card mb-4">
    <div class="card-body text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h1 class="mb-2" style="font-weight: bold; font-size: 2.5rem;">NeoMart</h1>
        <p class="mb-1" style="font-size: 1.1rem;"><i class="bi bi-geo-alt-fill"></i> Jl. Laksda Adisucipto No 29, Yogyakarta</p>
        <hr style="border-color: rgba(255,255,255,0.3); margin: 15px 0;">
        <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> LAPORAN PEMBELIAN BARANG</h4>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        <i class="bi bi-funnel"></i> Filter Laporan
    </div>
    <div class="card-body">
        <form action="{{ route('laporan.pembelian') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="tanggal_dari" class="form-label">Tanggal Dari</label>
                <input type="date" class="form-control" id="tanggal_dari" name="tanggal_dari"
                    value="{{ request('tanggal_dari') }}">
            </div>
            <div class="col-md-4">
                <label for="tanggal_sampai" class="form-label">Tanggal Sampai</label>
                <input type="date" class="form-control" id="tanggal_sampai" name="tanggal_sampai"
                    value="{{ request('tanggal_sampai') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('laporan.pembelian') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-table"></i> Data Laporan</span>
        @if($data->count() > 0)
        <a href="{{ route('laporan.cetak-pembelian', request()->all()) }}" target="_blank" class="btn btn-sm btn-success">
            <i class="bi bi-printer"></i> Cetak Laporan
        </a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
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
                    @forelse($data as $beli)
                    @foreach($beli->detailBeli as $detail)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{ $beli->detailBeli->count() }}">{{ $no++ }}</td>
                        <td rowspan="{{ $beli->detailBeli->count() }}">
                            {{ $beli->no_faktur }}
                        </td>
                        <td rowspan="{{ $beli->detailBeli->count() }}">{{ $beli->tanggal->format('d/m/Y') }}</td>
                        <td rowspan="{{ $beli->detailBeli->count() }}">{{ $beli->pemasok->nama_pemasok }}</td>
                        @endif
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>{{ $detail->quantity }} {{ $detail->barang->satuan }}</td>
                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($detail->quantity * $detail->harga, 0, ',', '.') }}</td>
                    </tr>
                    @php $grandTotal += ($detail->quantity * $detail->harga); @endphp
                    @endforeach
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Tidak ada data untuk periode yang dipilih</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($data->count() > 0)
                <tfoot class="table-light">
                    <tr>
                        <th colspan="7" class="text-end">GRAND TOTAL:</th>
                        <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection