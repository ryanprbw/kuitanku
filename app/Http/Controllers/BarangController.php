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
        // Ambil data barang terkait
        $barang = Barang::findOrFail($barang_id);

        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'mutasi_tambah' => 'nullable|integer',
            'mutasi_keluar' => 'nullable|integer',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil harga satuan dari tabel barang
        $validated['harga_satuan'] = $barang->harga_satuan;

        // Hitung Sisa Saldo Barang (Setelah mutasi)
        $validated['sisa_saldo_barang'] = $barang->jumlah + ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0);

        // Hitung Jumlah
        $validated['jumlah'] = ($validated['mutasi_tambah'] ?? 0) - ($validated['mutasi_keluar'] ?? 0);

        // Hitung Nilai Saldo (Jumlah Barang x Harga Satuan)
        $validated['nilai_saldo'] = $validated['sisa_saldo_barang'] * $validated['harga_satuan'];

        // Tambahkan barang_id ke data yang divalidasi
        $validated['barang_id'] = $barang_id;

        // Simpan data detail barang
        DetailBarang::create($validated);

        // Perbarui data barang di tabel barang
        $barang->jumlah = $validated['sisa_saldo_barang'];
        $barang->nilai_saldo = $barang->jumlah * $barang->harga_satuan;
        $barang->save();

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
            'keterangan' => 'required|string|max:255',
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
            'keterangan' => 'required|string|max:255',
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
