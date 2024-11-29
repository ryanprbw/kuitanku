<?php

namespace App\Http\Controllers;

use App\Models\KepalaDinas;
use Illuminate\Http\Request;

class KepalaDinasController extends Controller
{
    // Menampilkan daftar Kepala Dinas
    public function index()
    {
        $kepala_dinas = KepalaDinas::all();
        return view('kepala_dinas.index', compact('kepala_dinas'));
    }

    // Menampilkan form tambah Kepala Dinas
    public function create()
    {
        return view('kepala_dinas.create');
    }

    // Menyimpan data Kepala Dinas
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits:18|unique:kepala_dinas,NIP',
        ]);

        KepalaDinas::create($request->all());
        return redirect()->route('kepala_dinas.index')->with('success', 'Kepala Dinas berhasil ditambahkan');
    }

    // Menampilkan form edit Kepala Dinas
    public function edit($id)
    {
        $kepala_dinas = KepalaDinas::findOrFail($id);
        return view('kepala_dinas.edit', compact('kepala_dinas'));
    }

    // Memperbarui data Kepala Dinas
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|numeric|digits:18|unique:kepala_dinas,NIP,' . $id,
        ]);

        $kepala_dinas = KepalaDinas::findOrFail($id);
        $kepala_dinas->update($request->all());
        return redirect()->route('kepala_dinas.index')->with('success', 'Kepala Dinas berhasil diperbarui');
    }

    // Menghapus Kepala Dinas
    public function destroy($id)
    {
        KepalaDinas::destroy($id);
        return redirect()->route('kepala_dinas.index')->with('success', 'Kepala Dinas berhasil dihapus');
    }
}
