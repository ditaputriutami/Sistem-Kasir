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
        $totalNilaiBulanIni = Beli::whereMonth('tanggal', date('m'))
                                   ->whereYear('tanggal', date('Y'))
                                   ->sum('total');
        
        return view('dashboard', compact(
            'totalBarang',
            'totalPemasok',
            'totalTransaksiBulanIni',
            'totalNilaiBulanIni'
        ));
    }
}
