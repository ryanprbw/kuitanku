<?php

namespace App\Http\Controllers;

use App\Models\BukuPengeluaranBarang;
use Illuminate\Http\Request;

class BukuPengeluaranBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data barang
        $items = BukuPengeluaranBarang::all();

        // Return ke view barang.index
        return view('barang.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return ke view barang.create
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'nilai_saldo' => 'required|numeric',
            'sisa_saldo_barang' => 'required|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan data ke database
        BukuPengeluaranBarang::create($validated);

        // Redirect ke barang.index dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data barang berdasarkan ID
        $item = BukuPengeluaranBarang::findOrFail($id);

        // Return ke view barang.edit
        return view('barang.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_barang' => 'required|string|max:255',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'nilai_saldo' => 'required|numeric',
            'sisa_saldo_barang' => 'required|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil data barang berdasarkan ID
        $item = BukuPengeluaranBarang::findOrFail($id);

        // Update data
        $item->update($validated);

        // Redirect ke barang.index dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Ambil data barang berdasarkan ID
        $item = BukuPengeluaranBarang::findOrFail($id);

        // Hapus data
        $item->delete();

        // Redirect ke barang.index dengan pesan sukses
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
