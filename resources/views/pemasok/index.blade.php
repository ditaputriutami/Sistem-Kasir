@extends('layouts.app')

@section('title', 'Data Pemasok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-truck"></i> Data Pemasok</h2>
        <p class="text-muted mb-0">Kelola data pemasok/distributor</p>
    </div>
    <a href="{{ route('pemasok.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Pemasok
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama Pemasok</th>
                        <th>Alamat</th>
                        <th>No. Telepon</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasok as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><span class="badge bg-primary">{{ $item->kode_pemasok }}</span></td>
                        <td><strong>{{ $item->nama_pemasok }}</strong></td>
                        <td>{{ $item->alamat }}</td>
                        <td><i class="bi bi-telephone"></i> {{ $item->no_telepon }}</td>
                        <td>
                            <a href="{{ route('pemasok.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('pemasok.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-2">Belum ada data pemasok</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection