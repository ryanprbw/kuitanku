<?php
namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\KodeRekening;
use App\Models\RincianBelanjaUmum;
use App\Models\SubKegiatan;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubKegiatanController extends Controller
{
    /**
     * Menampilkan daftar SubKegiatan.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();

        // Menghitung total anggaran dan total realisasi sesuai dengan role user
        if ($user->role === 'superadmin') {
            // Untuk superadmin, ambil seluruh SubKegiatan
            $totalAnggaran = SubKegiatan::sum('anggaran');

            // Total realisasi dihitung berdasarkan anggaran yang sudah terpakai di KodeRekening
            $totalRealisasi = KodeRekening::sum('anggaran');

            // Menampilkan semua SubKegiatan
            $subKegiatans = SubKegiatan::with(['kegiatan', 'bidang'])
                ->paginate(10)
                ->through(function ($subKegiatan) {
                    // Menghitung anggaran realisasi untuk setiap sub kegiatan
                    $anggaranRealisasi = $subKegiatan->kodeRekenings()->sum('anggaran');

                    // Menghitung sisa anggaran sub kegiatan
                    $subKegiatan->sisa_anggaran = $subKegiatan->anggaran_awal - $anggaranRealisasi;
                    $subKegiatan->anggaran_kegiatan = $subKegiatan->kegiatan->anggaran; // Menyimpan anggaran kegiatan terkait
                    $subKegiatan->total_realisasi = $anggaranRealisasi; // Menyimpan total realisasi anggaran
    
                    return $subKegiatan;
                });

        } else {
            // Untuk pengguna selain superadmin, ambil SubKegiatan berdasarkan bidang user
            $totalAnggaran = SubKegiatan::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Total realisasi dihitung berdasarkan anggaran yang sudah terpakai di KodeRekening
            $totalRealisasi = KodeRekening::whereHas('subKegiatan', function ($query) use ($user) {
                return $query->where('bidang_id', $user->bidang_id);
            })->sum('anggaran');

            // Menampilkan SubKegiatan berdasarkan bidang yang dimiliki user
            $subKegiatans = SubKegiatan::where('bidang_id', $user->bidang_id)
                ->with(['kegiatan', 'bidang'])
                ->paginate(10)
                ->through(function ($subKegiatan) {
                    // Menghitung anggaran realisasi untuk setiap sub kegiatan
                    $anggaranRealisasi = $subKegiatan->kodeRekenings()->sum('anggaran');

                    // Menghitung sisa anggaran sub kegiatan
                    $subKegiatan->sisa_anggaran = $subKegiatan->anggaran_awal - $anggaranRealisasi;
                    $subKegiatan->anggaran_realisasi = $anggaranRealisasi; // Menyimpan anggaran realisasi
                    $subKegiatan->anggaran_kegiatan = $subKegiatan->kegiatan->anggaran; // Menyimpan anggaran kegiatan terkait
    
                    return $subKegiatan;
                });
        }

        // Mengirimkan data ke view
        return view('sub_kegiatan.index', compact('subKegiatans', 'totalAnggaran', 'totalRealisasi'));
    }





    /**
     * Menampilkan form untuk membuat SubKegiatan baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $kegiatans = Kegiatan::all();
            $bidangs = Bidang::all(); // Ambil semua bidang untuk superadmin
        } else {
            $kegiatans = Kegiatan::where('bidang_id', $user->bidang_id)->get();
            $bidangs = Bidang::where('id', $user->bidang_id)->get(); // Ambil bidang sesuai dengan user
        }

        return view('sub_kegiatan.create', compact('kegiatans', 'bidangs'));
    }





    /**
     * Menyimpan SubKegiatan baru.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
            'bidang_id' => 'required|exists:bidangs,id',
        ]);

        DB::beginTransaction();
        try {
            $kegiatan = Kegiatan::findOrFail($request->kegiatan_id);

            // Validasi anggaran kegiatan mencukupi
            if ($kegiatan->anggaran < $request->anggaran) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran Kegiatan tidak mencukupi.'])->withInput();
            }

            // Kurangi anggaran dari Kegiatan
            $kegiatan->anggaran -= $request->anggaran;
            $kegiatan->save();

            // Simpan SubKegiatan dengan bidang_id
            SubKegiatan::create($request->all());

            DB::commit();

            return redirect()->route('sub_kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Sub Kegiatan berhasil ditambahkan.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }



    /**
     * Menampilkan form untuk mengedit SubKegiatan.
     *
     * @param \App\Models\SubKegiatan $subKegiatan
     * @return \Illuminate\View\View
     */
    public function edit(SubKegiatan $subKegiatan)
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $kegiatans = Kegiatan::all();
            $bidangs = Bidang::all(); // Ambil semua bidang untuk superadmin
        } else {
            $kegiatans = Kegiatan::where('bidang_id', $user->bidang_id)->get();
            $bidangs = Bidang::where('id', $user->bidang_id)->get(); // Ambil bidang sesuai dengan user
        }

        return view('sub_kegiatan.edit', compact('subKegiatan', 'kegiatans', 'bidangs'));
    }


    /**
     * Memperbarui SubKegiatan.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\SubKegiatan $subKegiatan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SubKegiatan $subKegiatan)
    {
        $request->validate([
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'nama_sub_kegiatan' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:0',
        ]);


        DB::beginTransaction();
        try {
            $kegiatan = $subKegiatan->kegiatan;

            // Hitung selisih anggaran
            $selisihAnggaran = $subKegiatan->anggaran - $request->anggaran;

            // Update anggaran Kegiatan
            $kegiatan->anggaran += $selisihAnggaran;

            // Validasi anggaran kegiatan mencukupi
            if ($kegiatan->anggaran < 0) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran Kegiatan tidak mencukupi.'])->withInput();
            }

            $kegiatan->save();

            // Update SubKegiatan dengan bidang_id
            $subKegiatan->update($request->all());

            DB::commit();

            return redirect()->route('sub_kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Sub Kegiatan berhasil diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }



    /**
     * Menghapus SubKegiatan.
     *
     * @param \App\Models\SubKegiatan $subKegiatan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SubKegiatan $subKegiatan)
    {
        DB::beginTransaction();
        try {
            $kegiatan = $subKegiatan->kegiatan;

            // Kembalikan anggaran ke Kegiatan
            $kegiatan->anggaran += $subKegiatan->anggaran;
            $kegiatan->save();

            // Soft delete SubKegiatan
            $subKegiatan->delete();

            DB::commit();

            return redirect()->route('sub_kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Sub Kegiatan berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus Sub Kegiatan.']);
        }
    }



}

