@extends('layouts.app')

@section('title', 'Transaksi Pembelian')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-cart-plus"></i> Transaksi Pembelian</h2>
        <p class="text-muted mb-0">Daftar transaksi pembelian barang</p>
    </div>
    <a href="{{ route('beli.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Transaksi Baru
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>No. Faktur</th>
                        <th>Tanggal</th>
                        <th>Pemasok</th>
                        <th>Total</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beli as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-primary">{{ $item->no_faktur }}</span></td>
                        <td>{{ $item->tanggal->format('d/m/Y') }}</td>
                        <td>
                            <div><strong>{{ $item->pemasok->nama_pemasok }}</strong></div>
                            <small class="text-muted">{{ $item->pemasok->kode_pemasok }}</small>
                        </td>
                        <td><strong>Rp {{ number_format($item->total, 0, ',', '.') }}</strong></td>
                        <td>
                            <a href="{{ route('beli.show', $item->id) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form action="{{ route('beli.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada transaksi pembelian</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection