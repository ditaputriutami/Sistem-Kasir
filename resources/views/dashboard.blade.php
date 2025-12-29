@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    .dashboard-card {
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
        min-height: 140px;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        text-decoration: none;
        color: inherit;
    }

    .dashboard-card .card {
        height: 100%;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card:hover .card {
        border-left: 4px solid;
    }

    .dashboard-card:nth-child(1):hover .card {
        border-left-color: #0d6efd;
    }

    .dashboard-card:nth-child(2):hover .card {
        border-left-color: #198754;
    }

    .dashboard-card:nth-child(3):hover .card {
        border-left-color: #0dcaf0;
    }

    .dashboard-card:nth-child(4):hover .card {
        border-left-color: #ffc107;
    }
</style>

<div class="mb-4">
    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
    <p class="text-muted">Selamat datang di Sistem Pembelian Barang</p>
</div>

<div class="row">
    <!-- Card Total Barang -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('barang.index') }}" class="dashboard-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Barang</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalBarang }}</h2>
                            <small class="text-primary"><i class="bi bi-arrow-right-circle"></i> Lihat Detail</small>
                        </div>
                        <div class="text-primary" style="font-size: 3rem; opacity: 0.3;">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Card Total Pemasok -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('pemasok.index') }}" class="dashboard-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Pemasok</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalPemasok }}</h2>
                            <small class="text-success"><i class="bi bi-arrow-right-circle"></i> Lihat Detail</small>
                        </div>
                        <div class="text-success" style="font-size: 3rem; opacity: 0.3;">
                            <i class="bi bi-truck"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Card Transaksi Bulan Ini -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('beli.index') }}" class="dashboard-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Transaksi Bulan Ini</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalTransaksiBulanIni }}</h2>
                            <small class="text-info"><i class="bi bi-arrow-right-circle"></i> Lihat Detail</small>
                        </div>
                        <div class="text-info" style="font-size: 3rem; opacity: 0.3;">
                            <i class="bi bi-cart-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Card Total Nilai Bulan Ini -->
    <div class="col-md-6 col-lg-3 mb-4">
        <a href="{{ route('laporan.pembelian') }}" class="dashboard-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Nilai Pembelian</h6>
                            <h2 class="mb-0 fw-bold" style="font-size: 1.5rem;">Rp {{ number_format($totalNilaiBulanIni, 0, ',', '.') }}</h2>
                            <small class="text-warning"><i class="bi bi-arrow-right-circle"></i> Lihat Laporan</small>
                        </div>
                        <div class="text-warning" style="font-size: 3rem; opacity: 0.3;">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection