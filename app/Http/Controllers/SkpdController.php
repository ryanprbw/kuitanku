<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SkpdController extends Controller
{
    // Menampilkan daftar SKPD
    public function index()
    {
        $skpds = Skpd::withCount([
            'programs as total_realisasi' => function ($query) {
                $query->select(DB::raw('SUM(anggaran_awal)'));
            }
        ])
            ->paginate(10);

        // Gunakan setCollection() agar tetap berupa paginator
        $skpds->setCollection(
            $skpds->getCollection()->map(function ($skpd) {
                $skpd->total_anggaran = $skpd->anggaran_awal;
                $skpd->sisa_anggaran = $skpd->total_anggaran - $skpd->total_realisasi;
                return $skpd;
            })
        );

        return view('skpd.index', compact('skpds'));
    }

    // Menampilkan form untuk menambah SKPD baru
    public function create()
    {
        return view('skpd.create');
    }

    // Menampilkan detail SKPD
    public function show(Skpd $skpd)
    {
        return view('skpd.show', compact('skpd'));
    }

    // Menyimpan SKPD baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_skpd' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'anggaran_awal' => 'required|numeric|min:0',
        ]);

        Skpd::create($request->only(['nama_skpd', 'anggaran', 'anggaran_awal']));

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

        $skpd->update($request->only(['nama_skpd', 'anggaran', 'anggaran_awal']));

        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil diperbarui.');
    }

    // Menghapus SKPD
    public function destroy(Skpd $skpd)
    {
        DB::beginTransaction();
        try {
            // Soft delete semua program terkait
            $skpd->programs()->delete();

            // Soft delete SKPD
            $skpd->delete();

            DB::commit();
            return redirect()->route('skpd.index')->with('success', 'SKPD berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus SKPD.']);
        }
    }
}
