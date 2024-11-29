<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use Illuminate\Http\Request;

class BendaharaController extends Controller
{
    // Menampilkan daftar Bendahara
    public function index()
    {
        $bendahara = Bendahara::all(); // Ini akan mengambil data dari tabel bendaharas
        return view('bendahara.index', compact('bendahara'));
    }

    // Menampilkan form tambah Bendahara
    public function create()
    {
        return view('bendahara.create');
    }

    // Menyimpan data Bendahara
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits:18|unique:bendaharas,NIP', // Perbaiki nama tabel di sini
        ]);

        Bendahara::create($request->all());
        return redirect()->route('bendahara.index')->with('success', 'Bendahara berhasil ditambahkan');
    }

    // Menampilkan form edit Bendahara
    public function edit($id)
    {
        $bendahara = Bendahara::findOrFail($id);
        return view('bendahara.edit', compact('bendahara'));
    }

    // Memperbarui data Bendahara
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits:18|unique:bendaharas,NIP,' . $id, // Perbaiki nama tabel di sini
        ]);

        $bendahara = Bendahara::findOrFail($id);
        $bendahara->update($request->all());
        return redirect()->route('bendahara.index')->with('success', 'Bendahara berhasil diperbarui');
    }

    // Menghapus Bendahara
    public function destroy($id)
    {
        Bendahara::destroy($id);
        return redirect()->route('bendahara.index')->with('success', 'Bendahara berhasil dihapus');
    }
}

