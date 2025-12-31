<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pemasok;
use App\Models\Beli;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display dashboard
     */
    public function index()
    {
        // Statistik untuk dashboard
        $totalBarang = Barang::count();
        $totalPemasok = Pemasok::count();
        $totalTransaksiBulanIni = Beli::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->count();

        // Hitung total nilai dari detail pembelian
        $beliIdsBulanIni = Beli::whereMonth('tanggal', date('m'))
            ->whereYear('tanggal', date('Y'))
            ->pluck('id');

        $totalNilaiBulanIni = \App\Models\DetailBeli::whereIn('beli_id', $beliIdsBulanIni)
            ->selectRaw('SUM(quantity * harga) as total')
            ->value('total') ?? 0;

        return view('dashboard', compact(
            'totalBarang',
            'totalPemasok',
            'totalTransaksiBulanIni',
            'totalNilaiBulanIni'
        ));
    }
}
