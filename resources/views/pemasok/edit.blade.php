@extends('layouts.app')

@section('title', 'Edit Pemasok')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-pencil-square"></i> Edit Pemasok</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('pemasok.index') }}">Data Pemasok</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-pencil"></i> Form Edit Pemasok
            </div>
            <div class="card-body">
                <form action="{{ route('pemasok.update', $pemasok->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="kode_pemasok" class="form-label">Kode Pemasok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kode_pemasok') is-invalid @enderror"
                            id="kode_pemasok" name="kode_pemasok"
                            value="{{ old('kode_pemasok', $pemasok->kode_pemasok) }}"
                            placeholder="Contoh: PMS001, SUP001, etc" required>
                        <small class="text-muted">Kode unik untuk pemasok (huruf kapital tanpa spasi)</small>
                        @error('kode_pemasok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_pemasok" class="form-label">Nama Pemasok <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_pemasok') is-invalid @enderror"
                            id="nama_pemasok" name="nama_pemasok" value="{{ old('nama_pemasok', $pemasok->nama_pemasok) }}" required>
                        @error('nama_pemasok')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                            id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pemasok->alamat) }}</textarea>
                        @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_telepon" class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                            id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $pemasok->no_telepon) }}" required>
                        @error('no_telepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Update
                        </button>
                        <a href="{{ route('pemasok.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection