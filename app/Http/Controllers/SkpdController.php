<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class SkpdController extends Controller
{
    // Menampilkan daftar SKPD
    public function index()
    {
        $totalAnggaran = Skpd::sum('anggaran');
        $skpds = Skpd::paginate(10); // Gunakan paginate()
        return view('skpd.index', compact('skpds', 'totalAnggaran'));
    }

    // Menampilkan form untuk menambah SKPD baru
    public function create()
    {
        return view('skpd.create');
    }
    public function show(Skpd $skpds)
    {
        return view('skpd.show', compact('skpds'));
    }
    // Menyimpan SKPD baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_skpd' => 'required|string|max:255', // Pastikan menggunakan nama yang benar
            'anggaran' => 'required|numeric',
        ]);

        // Simpan data ke dalam database
        Skpd::create([
            'nama_skpd' => $request->nama_skpd, // Pastikan mengisi 'nama_skpd'
            'anggaran' => $request->anggaran,
        ]);

        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil ditambahkan.');
    }


    // Menampilkan form untuk mengedit SKPD
    public function edit(Skpd $skpd)
    {
        return view('skpd.edit', compact('skpd'));
    }

    // Memperbarui SKPD
    public function update(Request $request, Skpd $skpd)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255', // Ganti 'nama' menjadi 'nama_skpd'
            'anggaran' => 'required|numeric',
        ]);

        $skpd->update([
            'nama_skpd' => $request->nama_skpd, // Ganti 'nama' menjadi 'nama_skpd'
            'anggaran' => $request->anggaran,
        ]);

        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil diperbarui.');
    }

    // Menghapus SKPD
    public function destroy(Skpd $skpd)
    {
        $skpd->delete();
        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil dihapus.');
    }
}
