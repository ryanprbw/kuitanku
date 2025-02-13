<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Skpd;
use Illuminate\Http\Request;

class SkpdController extends Controller
{
    // Menampilkan daftar SKPD
    public function index()
    {
        $skpds = Skpd::with(['programs']) // Mengambil relasi programs
            ->paginate(10)
            ->through(function ($skpd) {
                // Hitung total realisasi anggaran yang sudah digunakan dalam program
                $totalRealisasi = $skpd->programs->sum('anggaran_awal'); // anggaran yang sudah digunakan oleh programs
    
                // Tentukan total anggaran yang ada pada SKPD (menggunakan anggaran_awal)
                $skpd->total_anggaran = $skpd->anggaran_awal;

                // Tentukan total realisasi anggaran
                $skpd->total_realisasi = $totalRealisasi;

                // Tentukan sisa anggaran
                $skpd->sisa_anggaran = $skpd->anggaran_awal - $totalRealisasi;

                return $skpd;
            });

        return view('skpd.index', compact('skpds'));
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
            'anggaran_awal' => 'required|numeric',
        ]);

        // Simpan data ke dalam database
        Skpd::create([
            'nama_skpd' => $request->nama_skpd, // Pastikan mengisi 'nama_skpd'
            'anggaran' => $request->anggaran,
            'anggaran_awal' => $request->anggaran_awal,
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
            'nama_skpd' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'anggaran_awal' => 'required|numeric|min:0',
        ]);

        // Validasi anggaran yang baru
        if ($request->anggaran < $skpd->anggaran) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran tidak boleh lebih kecil dari anggaran yang ada.'])->withInput();
        }

        // Update anggaran (tanpa merubah anggaran_awal)
        $skpd->update([
            'nama_skpd' => $request->nama_skpd,
            'anggaran' => $request->anggaran,
            'anggaran_awal' => $request->anggaran_awal,  // Hanya memperbarui anggaran, bukan anggaran_awal
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
