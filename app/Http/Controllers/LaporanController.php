<?php

namespace App\Http\Controllers;

use App\Models\Beli;
use App\Models\DetailBeli;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan rekap pembelian
     */
    public function pembelian(Request $request)
    {
        $query = Beli::with(['pemasok', 'detailBeli.barang']);
        
        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }
        
        $data = $query->orderBy('tanggal', 'desc')->get();
        
        return view('laporan.pembelian', compact('data'));
    }
    
    /**
     * Cetak laporan pembelian
     */
    public function cetakPembelian(Request $request)
    {
        $query = Beli::with(['pemasok', 'detailBeli.barang']);
        
        // Filter berdasarkan tanggal jika ada
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal', '<=', $request->tanggal_sampai);
        }
        
        $data = $query->orderBy('tanggal', 'desc')->get();
        $tanggalDari = $request->tanggal_dari;
        $tanggalSampai = $request->tanggal_sampai;
        
        return view('laporan.cetak-pembelian', compact('data', 'tanggalDari', 'tanggalSampai'));
    }
}
