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

        // Menghitung total anggaran untuk kode rekening (berdasarkan peran user)
        $totalAnggaran = KodeRekening::when($user->role !== 'superadmin', function ($query) use ($user) {
            $query->whereHas('subKegiatan', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        })->sum('anggaran_awal');

        // Menghitung total anggaran realisasi (dari tabel rincian belanja yang terkait dengan kode rekening)
        $totalRealisasi = KodeRekening::when($user->role !== 'superadmin', function ($query) use ($user) {
            $query->whereHas('subKegiatan', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        })->withSum('rincianBelanjaUmum', 'anggaran')
            ->withSum('rincianBelanjaSppd', 'anggaran') // Menambahkan rincianBelanjaSppd ke dalam penghitungan
            ->get()->sum(function ($kodeRekening) {
                // Menghitung total realisasi anggaran dari rincianBelanjaUmum dan rincianBelanjaSppd
                $anggaranRealisasi = $kodeRekening->rincian_belanja_umum_sum_anggaran + $kodeRekening->rincian_belanja_sppd_sum_anggaran;
                return $anggaranRealisasi;
            });

        // Mengambil semua kode rekening dengan eager loading dan filter bidang jika perlu
        $kodeRekenings = KodeRekening::with(['subKegiatan', 'rincianBelanjaUmum', 'rincianBelanjaSppd']) // Menambahkan eager loading untuk rincianBelanjaSppd
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->whereHas('subKegiatan', function ($q) use ($user) {
                    $q->where('bidang_id', $user->bidang_id);
                });
            })
            ->paginate(20)
            ->through(function ($kodeRekening) {
                // Menghitung anggaran realisasi dari rincian belanja umum dan rincian belanja sppd
                $anggaranRealisasi = $kodeRekening->rincianBelanjaUmum()->sum('anggaran') + $kodeRekening->rincianBelanjaSppd()->sum('anggaran');

                // Menghitung sisa anggaran (total anggaran - realisasi)
                $kodeRekening->anggaran_realisasi = $anggaranRealisasi;
                $kodeRekening->sisa_anggaran = $kodeRekening->anggaran_awal - $anggaranRealisasi;

                return $kodeRekening;
            });

        // Mengirimkan data ke view
        return view('kode_rekening.index', compact('kodeRekenings', 'totalAnggaran', 'totalRealisasi'));
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
            'bidang_id' => 'required|exists:bidangs,id', // ✅ Tambahkan validasi bidang
            'nama_kode_rekening' => 'required|string|max:255',
            'anggaran_awal' => 'required|numeric|min:0',
            'anggaran' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subKegiatan = SubKegiatan::findOrFail($request->sub_kegiatan_id);

            if ($subKegiatan->anggaran < $request->anggaran) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Sub Kegiatan tidak mencukupi.'])->withInput();
            }

            // Simpan data Kode Rekening dengan `bidang_id`
            $kodeRekening = KodeRekening::create([
                'sub_kegiatan_id' => $request->sub_kegiatan_id,
                'bidang_id' => $request->bidang_id, // ✅ Tambahkan bidang_id
                'nama_kode_rekening' => $request->nama_kode_rekening,
                'anggaran_awal' => $request->anggaran_awal,
                'anggaran' => $request->anggaran,
            ]);

            // Kurangi anggaran dari Sub Kegiatan
            $subKegiatan->anggaran -= $request->anggaran;
            $subKegiatan->save();

            DB::commit();
            return redirect()->route('kode_rekening.index')->with('success', 'Kode Rekening berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
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
            'bidang_id' => 'required|exists:bidangs,id', // ✅ Tambahkan validasi bidang
            'nama_kode_rekening' => 'required|string|max:255',
            'anggaran_awal' => 'required|numeric|min:0',
            'anggaran' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $subKegiatan = $kodeRekening->subKegiatan;
            $oldAnggaran = $kodeRekening->anggaran;

            // Perbarui anggaran SubKegiatan berdasarkan selisihnya
            $subKegiatan->anggaran += $oldAnggaran; // Kembalikan anggaran lama
            $subKegiatan->anggaran -= $request->anggaran; // Kurangi dengan anggaran baru

            if ($subKegiatan->anggaran < 0) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Sub Kegiatan tidak mencukupi.'])->withInput();
            }

            $subKegiatan->save();

            // Perbarui data Kode Rekening dengan `bidang_id`
            $kodeRekening->update([
                'sub_kegiatan_id' => $request->sub_kegiatan_id,
                'bidang_id' => $request->bidang_id, // ✅ Tambahkan bidang_id
                'nama_kode_rekening' => $request->nama_kode_rekening,
                'anggaran_awal' => $request->anggaran_awal,
                'anggaran' => $request->anggaran,
            ]);

            DB::commit();
            return redirect()->route('kode_rekening.index')->with('success', 'Kode Rekening berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
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
        DB::beginTransaction();
        try {
            $subKegiatan = $kodeRekening->subKegiatan;

            if (!$subKegiatan) {
                return redirect()->back()->withErrors(['error' => 'Sub Kegiatan tidak ditemukan.']);
            }

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
