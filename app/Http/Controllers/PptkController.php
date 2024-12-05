<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Pptk;
use Illuminate\Http\Request;

class PptkController extends Controller
{
    public function index()
    {
        $totalPptk = Pptk::count();
        $pptks = Pptk::with('bidang')->paginate(10); // Tambahkan eager loading dan pagination
        return view('pptks.index', compact('pptks', 'totalPptk'));
    }

    public function create()
    {
        $bidangs = Bidang::all();
        return view('pptks.create', compact('bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|min:5|regex:/^[A-Za-z\s.,]+$/', // Nama minimal 5 karakter
            'nip' => 'required|numeric|digits:18', // NIP harus angka dengan panjang tepat 18 digit
            'bidang_id' => 'required|exists:bidangs,id', // Validasi foreign key bidang_id
        ]);

        Pptk::create($request->only(['nama', 'nip', 'bidang_id']));

        return redirect()->route('pptks.index')->with('success', 'PPTK berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pptks = Pptk::findOrFail($id);
        $bidangs = Bidang::all();
        return view('pptks.edit', compact('pptks', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|min:5|regex:/^[A-Za-z\s.,]+$/', // Nama minimal 5 karakter
            'nip' => 'required|numeric|digits:18', // NIP harus angka dengan panjang tepat 18 digit
            'bidang_id' => 'required|exists:bidangs,id', // Validasi foreign key bidang_id
        ]);

        $pptk = Pptk::findOrFail($id);
        $pptk->update($request->only(['nama', 'nip', 'bidang_id']));

        return redirect()->route('pptks.index')->with('success', 'PPTK berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pptk = Pptk::findOrFail($id);
        $pptk->delete();

        return redirect()->route('pptks.index')->with('success', 'PPTK berhasil dihapus.');
    }
}
