<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\KodeRekening;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KodeRekeningController extends Controller
{
    /**
     * Menampilkan daftar Kode Rekening.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Menghitung total anggaran
        $totalAnggaran = KodeRekening::when($user->role !== 'superadmin', function ($query) use ($user) {
            // Jika user bukan superadmin, hitung hanya untuk bidang_id yang sesuai
            $query->whereHas('subKegiatan', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        })->sum('anggaran'); // Anggaran dihitung berdasarkan kode rekening yang sesuai

        // Mendapatkan kode rekening dengan eager loading subKegiatan dan filter berdasarkan bidang_id jika perlu
        $kodeRekenings = KodeRekening::with('subKegiatan')
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->whereHas('subKegiatan', function ($q) use ($user) {
                    $q->where('bidang_id', $user->bidang_id);
                });
            })
            ->paginate(20);

        // Mengirimkan data kode rekening dan total anggaran ke view
        return view('kode_rekening.index', compact('kodeRekenings', 'totalAnggaran'));
    }


    public function show($id)
    {
        // Ambil data kode rekening berdasarkan ID
        $kodeRekening = KodeRekening::with(['subKegiatan', 'bidang'])->findOrFail($id);

        // Tampilkan view show.blade.php dengan data kode rekening
        return view('kode_rekening.show', compact('kodeRekening'));
    }

    /**
     * Menampilkan form untuk membuat Kode Rekening baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subKegiatans = SubKegiatan::all(); // Ambil semua data Sub Kegiatan
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        return view('kode_rekening.create', compact('subKegiatans', 'bidangs'));
    }

    /**
     * Menyimpan Kode Rekening baru.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
            'nama_kode_rekening' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
        ]);

        $subKegiatan = SubKegiatan::findOrFail($request->sub_kegiatan_id);

        // Validasi anggaran pada SubKegiatan mencukupi
        if ($subKegiatan->anggaran < $request->anggaran) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Sub Kegiatan tidak mencukupi.'])->withInput();
        }

        // Simpan data Kode Rekening
        $kodeRekening = KodeRekening::create($request->all());

        // Kurangi anggaran pada Sub Kegiatan
        $subKegiatan->kurangiAnggaran($request->anggaran);

        return redirect()->route('kode_rekening.index')->with('success', 'Kode Rekening berhasil ditambahkan.');
    }


    /**
     * Menampilkan form untuk mengedit Kode Rekening.
     *
     * @param  \App\Models\KodeRekening $kodeRekening
     * @return \Illuminate\View\View
     */
    public function edit(KodeRekening $kodeRekening)
    {
        $subKegiatans = SubKegiatan::all(); // Ambil semua data Sub Kegiatan
        $bidangs = Bidang::all(); // Ambil semua data Bidang
        return view('kode_rekening.edit', compact('kodeRekening', 'subKegiatans', 'bidangs'));
    }

    /**
     * Memperbarui Kode Rekening.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\KodeRekening $kodeRekening
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, KodeRekening $kodeRekening)
    {
        $request->validate([
            'sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
            'nama_kode_rekening' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
        ]);

        $subKegiatan = $kodeRekening->subKegiatan;
        $oldAnggaran = $kodeRekening->anggaran;

        // Validasi anggaran baru mencukupi
        if ($subKegiatan->anggaran + $oldAnggaran < $request->anggaran) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Sub Kegiatan tidak mencukupi untuk pembaruan.'])->withInput();
        }

        DB::beginTransaction();
        try {
            // Perbarui data Kode Rekening
            $kodeRekening->update($request->all());

            // Sesuaikan anggaran pada Sub Kegiatan
            $subKegiatan->anggaran += $oldAnggaran; // Tambahkan kembali anggaran lama
            $subKegiatan->anggaran -= $request->anggaran; // Kurangi dengan anggaran baru
            $subKegiatan->save();

            DB::commit();

            return redirect()->route('kode_rekening.index')->with('success', 'Kode Rekening berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage()])->withInput();
        }
    }



    /**
     * Menghapus Kode Rekening.
     *
     * @param  \App\Models\KodeRekening $kodeRekening
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(KodeRekening $kodeRekening)
    {
        $subKegiatan = $kodeRekening->subKegiatan;

        if (!$subKegiatan) {
            return redirect()->back()->withErrors(['error' => 'Sub Kegiatan tidak ditemukan.']);
        }

        DB::beginTransaction();
        try {
            // Kembalikan anggaran ke Sub Kegiatan
            $subKegiatan->anggaran += $kodeRekening->anggaran;
            $subKegiatan->save();

            // Hapus Kode Rekening
            $kodeRekening->delete();

            DB::commit();

            return redirect()->route('kode_rekening.index')->with('success', 'Kode Rekening berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()]);
        }
    }
}
