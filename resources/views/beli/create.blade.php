@extends('layouts.app')

@section('title', 'Transaksi Pembelian Baru')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-cart-plus"></i> Transaksi Pembelian Baru</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('beli.index') }}">Transaksi Pembelian</a></li>
            <li class="breadcrumb-item active">Baru</li>
        </ol>
    </nav>
</div>

<form action="{{ route('beli.store') }}" method="POST" id="formBeli">
    @csrf
    <input type="hidden" id="barangData" value='{{ json_encode($barang) }}'>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text"></i> Informasi Transaksi
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_faktur" class="form-label">No. Faktur</label>
                                <input type="text" class="form-control" id="no_faktur" value="{{ $noFaktur }}" readonly>
                                <small class="text-muted">Nomor faktur otomatis</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="pemasok_id" class="form-label">Pemasok <span class="text-danger">*</span></label>
                        <select class="form-select @error('pemasok_id') is-invalid @enderror"
                            id="pemasok_id" name="pemasok_id" required>
                            <option value="">Pilih Pemasok</option>
                            @foreach($pemasok as $p)
                            <option value="{{ $p->id }}" {{ old('pemasok_id') == $p->id ? 'selected' : '' }}>
                                [{{ $p->kode_pemasok }}] {{ $p->nama_pemasok }}
                            </option>
                            @endforeach
                        </select>
                        @error('pemasok_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-list-ul"></i> Detail Barang</span>
                    <button type="button" class="btn btn-sm btn-success" id="btnTambahItem">
                        <i class="bi bi-plus-circle"></i> Tambah Item
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tableItems">
                            <thead class="table-light">
                                <tr>
                                    <th width="30%">Barang</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Harga</th>
                                    <th width="20%">Subtotal</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsContainer">
                                <!-- Items akan ditambahkan di sini via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-calculator"></i> Total Pembelian
                </div>
                <div class="card-body">
                    <h2 class="text-center mb-3">
                        <span id="totalDisplay">Rp 0</span>
                    </h2>
                    <hr>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-save"></i> Simpan Transaksi
                        </button>
                        <a href="{{ route('beli.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                    <div class="alert alert-info mt-3 mb-0">
                        <small>
                            <i class="bi bi-info-circle"></i> Stok barang akan otomatis bertambah setelah transaksi disimpan.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // Data barang dari server
    const barangData = JSON.parse(document.getElementById('barangData').value);
    let itemIndex = 0;

    // Tambah item baru
    document.getElementById('btnTambahItem').addEventListener('click', function() {
        tambahItem();
    });

    function tambahItem() {
        const container = document.getElementById('itemsContainer');
        const row = document.createElement('tr');
        row.id = `item-${itemIndex}`;

        let optionsHtml = '<option value="">Pilih Barang</option>';
        barangData.forEach(function(barang) {
            optionsHtml += `<option value="${barang.id}" data-harga="${barang.harga_beli}">
                ${barang.nama_barang} (Stok: ${barang.stok} ${barang.satuan})
            </option>`;
        });

        row.innerHTML = `
            <td>
                <select class="form-select form-select-sm barang-select" name="items[${itemIndex}][barang_id]" required>
                    ${optionsHtml}
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm quantity-input" 
                       name="items[${itemIndex}][quantity]" min="1" value="1" required>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm harga-input" 
                       name="items[${itemIndex}][harga]" min="0" value="0" required>
            </td>
            <td>
                <input type="text" class="form-control form-control-sm subtotal-display" 
                       value="Rp 0" readonly>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger btn-hapus-item" data-index="${itemIndex}">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        container.appendChild(row);

        // Event listeners untuk item baru
        const barangSelect = row.querySelector('.barang-select');
        const quantityInput = row.querySelector('.quantity-input');
        const hargaInput = row.querySelector('.harga-input');
        const btnHapus = row.querySelector('.btn-hapus-item');

        // Auto-fill harga saat barang dipilih
        barangSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga') || 0;
            hargaInput.value = harga;
            hitungSubtotal(row);
        });

        // Hitung subtotal saat quantity atau harga berubah
        quantityInput.addEventListener('input', function() {
            hitungSubtotal(row);
        });

        hargaInput.addEventListener('input', function() {
            hitungSubtotal(row);
        });

        // Hapus item
        btnHapus.addEventListener('click', function() {
            row.remove();
            hitungTotal();
        });

        itemIndex++;
    }

    function hitungSubtotal(row) {
        const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
        const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
        const subtotal = quantity * harga;

        row.querySelector('.subtotal-display').value = formatRupiah(subtotal);
        hitungTotal();
    }

    function hitungTotal() {
        let total = 0;
        document.querySelectorAll('#itemsContainer tr').forEach(function(row) {
            const quantity = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const harga = parseFloat(row.querySelector('.harga-input').value) || 0;
            total += quantity * harga;
        });

        document.getElementById('totalDisplay').textContent = formatRupiah(total);
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    // Validasi form sebelum submit
    document.getElementById('formBeli').addEventListener('submit', function(e) {
        const itemsCount = document.querySelectorAll('#itemsContainer tr').length;
        if (itemsCount === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 barang!');
            return false;
        }
    });

    // Tambah 1 item default saat halaman dimuat
    window.addEventListener('DOMContentLoaded', function() {
        tambahItem();
    });
</script>
@endsection