<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    public function show($id)
    {
        // Mengambil data barang berdasarkan ID dengan relasi detail barang
        $barang = Barang::with('detailBarang')->findOrFail($id);

        // Return ke view detail barang
        return view('barang.show', compact('barang'));
    }

    public function createDetail($barang_id)
    {
        // Ambil data barang berdasarkan ID
        $barang = Barang::findOrFail($barang_id);

        // Return ke view tambah detail barang
        return view('barang.create-detail', compact('barang'));
    }
    public function storeDetail(Request $request, $barang_id)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'harga_satuan' => 'required|numeric',
            'sisa_saldo_barang' => 'required|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Hitung Jumlah dan Nilai Saldo
        $jumlah = ($validated['sisa_saldo_barang'] + ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0)) * $validated['harga_satuan'];
        $validated['jumlah'] = $jumlah;
        $validated['nilai_saldo'] = $jumlah;

        // Tambahkan barang_id
        $validated['barang_id'] = $barang_id;

        DetailBarang::create($validated);

        return redirect()->route('barang.show', $barang_id)->with('success', 'Detail barang berhasil ditambahkan.');
    }



    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
        ]);

        // Hitung nilai saldo
        $validated['nilai_saldo'] = $validated['jumlah'] * $validated['harga_satuan'];

        Barang::create($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_satuan' => 'required|numeric',
            'jumlah' => 'required|integer',
            'nilai_saldo' => 'required|numeric',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($validated);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
