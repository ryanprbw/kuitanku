<?php

namespace App\Http\Controllers;

use App\Models\KodeRekeningBidang;
use App\Models\KodeRekening;
use App\Models\Bidang;
use Illuminate\Http\Request;

class KodeRekeningBidangController extends Controller
{
    // Menampilkan daftar Kode Rekening Bidang
    public function index()
    {
        $kodeRekeningBidangs = KodeRekeningBidang::with(['kodeRekening', 'bidang'])->get();
        return view('kode_rekening_bidang.index', compact('kodeRekeningBidangs'));
    }

    // Menampilkan form untuk menambah Kode Rekening Bidang
    public function create()
    {
        $kodeRekenings = KodeRekening::all();
        $bidangs = Bidang::all();
        return view('kode_rekening_bidang.create', compact('kodeRekenings', 'bidangs'));
    }

    // Menyimpan Kode Rekening Bidang baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_rekenings_id' => 'required|exists:kode_rekenings,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'anggaran' => 'required|numeric',
        ]);

        // Simpan data Kode Rekening Bidang
        $kodeRekeningBidang = KodeRekeningBidang::create($request->all());

        // Kurangi anggaran pada Kode Rekening
        $kodeRekening = KodeRekening::find($request->kode_rekenings_id);
        $kodeRekening->anggaran -= $request->anggaran;  // Mengurangi anggaran sesuai dengan nilai yang dimasukkan
        $kodeRekening->save(); // Simpan perubahan anggaran

        return redirect()->route('kode-rekening-bidang.index')->with('success', 'Kode Rekening Bidang berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit Kode Rekening Bidang
    public function edit(KodeRekeningBidang $kodeRekeningBidang)
    {
        $kodeRekenings = KodeRekening::all();
        $bidangs = Bidang::all();
        return view('kode_rekening_bidang.edit', compact('kodeRekeningBidang', 'kodeRekenings', 'bidangs'));
    }

    // Memperbarui data Kode Rekening Bidang
    public function update(Request $request, KodeRekeningBidang $kodeRekeningBidang)
    {
        $request->validate([
            'kode_rekenings_id' => 'required|exists:kode_rekenings,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'anggaran' => 'required|numeric',
        ]);

        // Menyimpan anggaran lama sebelum update
        $oldAnggaran = $kodeRekeningBidang->anggaran;

        // Update data Kode Rekening Bidang
        $kodeRekeningBidang->update($request->all());

        // Mengurangi anggaran yang baru, menambahkan kembali anggaran lama
        $kodeRekening = KodeRekening::find($request->kode_rekenings_id);

        // Mengurangi anggaran baru dan menambahkan anggaran lama yang diupdate
        $kodeRekening->anggaran += $oldAnggaran;  // Mengembalikan anggaran lama
        $kodeRekening->anggaran -= $request->anggaran;  // Mengurangi anggaran baru
        $kodeRekening->save();

        return redirect()->route('kode-rekening-bidang.index')->with('success', 'Kode Rekening Bidang berhasil diperbarui.');
    }

    // Menghapus Kode Rekening Bidang
    public function destroy(KodeRekeningBidang $kodeRekeningBidang)
    {
        // Ambil anggaran sebelum dihapus
        $anggaran = $kodeRekeningBidang->anggaran;
        $kodeRekening = $kodeRekeningBidang->kodeRekening;

        // Hapus data Kode Rekening Bidang
        $kodeRekeningBidang->delete();

        // Mengembalikan anggaran setelah penghapusan
        $kodeRekening->anggaran += $anggaran;  // Menambah kembali anggaran yang dihapus
        $kodeRekening->save();

        return redirect()->route('kode-rekening-bidang.index')->with('success', 'Kode Rekening Bidang berhasil dihapus.');
    }
}
