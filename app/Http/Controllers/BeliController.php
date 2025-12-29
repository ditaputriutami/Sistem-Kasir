<?php

namespace App\Http\Controllers;

use App\Models\Beli;
use App\Models\DetailBeli;
use App\Models\Pemasok;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beli = Beli::with('pemasok')->oldest()->get();
        return view('beli.index', compact('beli'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pemasok = Pemasok::all();
        $barang = Barang::all();
        $noFaktur = Beli::generateNoFaktur();

        return view('beli.create', compact('pemasok', 'barang', 'noFaktur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'pemasok_id' => 'required|exists:pemasok,id',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barang,id',
            'items.*.jumlah' => 'required|numeric|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0'
        ], [
            'pemasok_id.required' => 'Pemasok harus dipilih',
            'pemasok_id.exists' => 'Pemasok tidak valid',
            'tanggal.required' => 'Tanggal harus diisi',
            'tanggal.date' => 'Tanggal tidak valid',
            'items.required' => 'Minimal harus ada 1 barang',
            'items.min' => 'Minimal harus ada 1 barang',
            'items.*.barang_id.required' => 'Barang harus dipilih',
            'items.*.barang_id.exists' => 'Barang tidak valid',
            'items.*.jumlah.required' => 'Jumlah harus diisi',
            'items.*.jumlah.numeric' => 'Jumlah harus berupa angka',
            'items.*.jumlah.min' => 'Jumlah minimal 1',
            'items.*.harga_beli.required' => 'Harga beli harus diisi',
            'items.*.harga_beli.numeric' => 'Harga beli harus berupa angka',
            'items.*.harga_beli.min' => 'Harga beli minimal 0'
        ]);

        // Gunakan database transaction untuk konsistensi data
        DB::beginTransaction();

        try {
            // Generate nomor faktur
            $noFaktur = Beli::generateNoFaktur();

            // Hitung total
            $total = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_beli'];
                $total += $subtotal;
            }

            // Simpan header pembelian
            $beli = Beli::create([
                'no_faktur' => $noFaktur,
                'tanggal' => $request->tanggal,
                'pemasok_id' => $request->pemasok_id,
                'total' => $total
            ]);

            // Simpan detail pembelian dan update stok
            foreach ($request->items as $item) {
                $subtotal = $item['jumlah'] * $item['harga_beli'];

                // Simpan detail pembelian
                DetailBeli::create([
                    'beli_id' => $beli->id,
                    'barang_id' => $item['barang_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal' => $subtotal
                ]);

                // Update stok barang (OTOMATIS BERTAMBAH)
                $barang = Barang::find($item['barang_id']);
                $barang->stok += $item['jumlah'];
                $barang->save();
            }

            DB::commit();

            return redirect()->route('beli.index')
                ->with('success', 'Transaksi pembelian berhasil disimpan. Stok barang telah diupdate.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Beli $beli)
    {
        $beli->load('pemasok', 'detailBeli.barang');
        return view('beli.show', compact('beli'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beli $beli)
    {
        // Untuk kesederhanaan, edit tidak diimplementasikan
        // Karena akan kompleks untuk rollback stok
        return redirect()->route('beli.index')
            ->with('info', 'Edit transaksi tidak tersedia. Silakan hapus dan buat transaksi baru.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beli $beli)
    {
        // Tidak diimplementasikan
        return redirect()->route('beli.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beli $beli)
    {
        DB::beginTransaction();

        try {
            // Rollback stok barang
            foreach ($beli->detailBeli as $detail) {
                $barang = Barang::find($detail->barang_id);
                $barang->stok -= $detail->jumlah;
                $barang->save();
            }

            // Hapus transaksi (detail akan terhapus otomatis karena cascade)
            $beli->delete();

            DB::commit();

            return redirect()->route('beli.index')
                ->with('success', 'Transaksi pembelian berhasil dihapus. Stok barang telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
