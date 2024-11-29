<?php
namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Bidang;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    // Menampilkan daftar Pegawai
    public function index()
{
    // Menggunakan paginate() untuk mendapatkan pagination
    $pegawais = Pegawai::with('bidang')->paginate(10); // 10 data per halaman
    return view('pegawais.index', compact('pegawais'));
}


    // Menampilkan form tambah Pegawai
    public function create()
    {
        $bidangs = Bidang::all(); // Mengambil semua bidang
        return view('pegawais.create', compact('bidangs'));
    }

    // Menyimpan data Pegawai
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'nullable|numeric|digits:18|unique:pegawais,nip',
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nomor_rekening' => 'required|numeric',
            'nama_bank' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,id', // Pastikan bidang_id valid
        ]);

        Pegawai::create($request->all());
        return redirect()->route('pegawais.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    // Menampilkan form edit Pegawai
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $bidangs = Bidang::all(); // Mengambil semua bidang
        return view('pegawais.edit', compact('pegawai', 'bidangs'));
    }

    // Memperbarui data Pegawai
    public function update(Request $request, $id)
    {
        $request->validate([
            'nip' => 'nullable|numeric|digits:18|unique:pegawais,nip,' . $id,
            'nama' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nomor_rekening' => 'required|numeric',
            'nama_bank' => 'required|string|max:255',
            'bidang_id' => 'required|exists:bidangs,id', // Pastikan bidang_id valid
        ]);

        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        return redirect()->route('pegawais.index')->with('success', 'Pegawai berhasil diperbarui');
    }

    // Menghapus Pegawai
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id); // Periksa keberadaan pegawai
        $pegawai->delete(); // Hapus data
        return redirect()->route('pegawais.index')->with('success', 'Pegawai berhasil dihapus');
    }
    
}
