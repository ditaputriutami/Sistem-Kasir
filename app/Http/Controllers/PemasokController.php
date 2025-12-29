<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemasok = Pemasok::oldest()->get();
        return view('pemasok.index', compact('pemasok'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pemasok.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok|max:20',
            'nama_pemasok' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required|numeric'
        ], [
            'kode_pemasok.required' => 'Kode pemasok harus diisi',
            'kode_pemasok.unique' => 'Kode pemasok sudah digunakan',
            'kode_pemasok.max' => 'Kode pemasok maksimal 20 karakter',
            'nama_pemasok.required' => 'Nama pemasok harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_telepon.required' => 'Nomor telepon harus diisi',
            'no_telepon.numeric' => 'Nomor telepon harus berupa angka'
        ]);

        // Konversi kode pemasok ke huruf kapital dan hapus spasi
        $validated['kode_pemasok'] = strtoupper(str_replace(' ', '', $validated['kode_pemasok']));

        Pemasok::create($validated);

        return redirect()->route('pemasok.index')
            ->with('success', 'Data pemasok berhasil ditambahkan dengan kode: ' . $validated['kode_pemasok']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemasok $pemasok)
    {
        return view('pemasok.show', compact('pemasok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemasok $pemasok)
    {
        return view('pemasok.edit', compact('pemasok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemasok $pemasok)
    {
        // Validasi input
        $validated = $request->validate([
            'kode_pemasok' => 'required|unique:pemasok,kode_pemasok,' . $pemasok->id . '|max:20',
            'nama_pemasok' => 'required',
            'alamat' => 'required',
            'no_telepon' => 'required|numeric'
        ], [
            'kode_pemasok.required' => 'Kode pemasok harus diisi',
            'kode_pemasok.unique' => 'Kode pemasok sudah digunakan',
            'kode_pemasok.max' => 'Kode pemasok maksimal 20 karakter',
            'nama_pemasok.required' => 'Nama pemasok harus diisi',
            'alamat.required' => 'Alamat harus diisi',
            'no_telepon.required' => 'Nomor telepon harus diisi',
            'no_telepon.numeric' => 'Nomor telepon harus berupa angka'
        ]);

        // Konversi kode pemasok ke huruf kapital dan hapus spasi
        $validated['kode_pemasok'] = strtoupper(str_replace(' ', '', $validated['kode_pemasok']));

        $pemasok->update($validated);

        return redirect()->route('pemasok.index')
            ->with('success', 'Data pemasok berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemasok $pemasok)
    {
        $pemasok->delete();

        return redirect()->route('pemasok.index')
            ->with('success', 'Data pemasok berhasil dihapus');
    }
}
