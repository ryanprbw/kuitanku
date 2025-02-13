<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Skpd;
use App\Http\Requests\KegiatanRequest;
use App\Models\SubKegiatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KegiatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            // Total Anggaran untuk semua kegiatan
            $totalAnggaran = Kegiatan::sum('anggaran');

            // Total Realisasi (dari SubKegiatan, sum anggaran yang sesuai dengan kegiatan_id)
            $totalRealisasi = SubKegiatan::sum('anggaran');

            // Mendapatkan semua kegiatan dan menghitung sisa anggaran serta total realisasi
            $kegiatans = Kegiatan::with('program', 'bidang')
                ->paginate(10)
                ->through(function ($kegiatan) {
                    // Menghitung sisa anggaran per kegiatan
                    $kegiatan->sisa_anggaran = $kegiatan->anggaran_awal - $kegiatan->anggaran;

                    // Menghitung total realisasi untuk masing-masing kegiatan berdasarkan SubKegiatan
                    $kegiatan->total_realisasi = SubKegiatan::where('kegiatan_id', $kegiatan->id)
                        ->sum('anggaran_awal'); // Sum anggaran dari SubKegiatan yang terkait dengan kegiatan
    
                    return $kegiatan;
                });
        } else {
            // Total Anggaran untuk kegiatan berdasarkan bidang_id pengguna
            $totalAnggaran = Kegiatan::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Total Realisasi untuk subkegiatan berdasarkan bidang_id pengguna
            $totalRealisasi = SubKegiatan::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Mendapatkan kegiatan yang terkait dengan bidang pengguna
            $kegiatans = Kegiatan::where('bidang_id', $user->bidang_id)
                ->with('program', 'bidang')
                ->paginate(10)
                ->through(function ($kegiatan) {
                    $kegiatan->sisa_anggaran = $kegiatan->anggaran_awal - $kegiatan->anggaran;

                    // Menghitung total realisasi untuk masing-masing kegiatan berdasarkan SubKegiatan
                    $kegiatan->total_realisasi = SubKegiatan::where('kegiatan_id', $kegiatan->id)
                        ->sum('anggaran_awal'); // Sum anggaran dari SubKegiatan yang terkait dengan kegiatan
    
                    return $kegiatan;
                });
        }

        return view('kegiatan.index', compact('kegiatans', 'totalAnggaran', 'totalRealisasi'));
    }



    public function create()
    {
        $programs = Program::all();
        $bidangs = Bidang::all();
        return view('kegiatan.create', compact('programs', 'bidangs'));
    }

    public function store(KegiatanRequest $request)
    {
        DB::beginTransaction();
        try {
            $program = Program::findOrFail($request->program_id);

            // Periksa apakah anggaran lebih besar dari anggaran yang tersedia pada program
            if ($request->anggaran > $program->anggaran) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran kegiatan tidak boleh lebih besar dari anggaran program.'])->withInput();
            }

            // Kurangi anggaran pada program
            $program->anggaran -= $request->anggaran;
            $program->save();

            // Simpan data kegiatan baru
            Kegiatan::create([
                'program_id' => $request->program_id,
                'bidang_id' => $request->bidang_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'anggaran_awal' => $request->anggaran_awal,
                'anggaran' => $request->anggaran,
            ]);

            DB::commit();
            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil ditambahkan dan anggaran program diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan kegiatan: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }


    public function edit(Kegiatan $kegiatan)
    {
        $programs = Program::all();
        $bidangs = Bidang::all();
        return view('kegiatan.edit', compact('kegiatan', 'programs', 'bidangs'));
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'anggaran_awal' => 'required|numeric|min:0',
            'anggaran' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Hitung selisih anggaran
            $selisihAnggaranAwal = $request->anggaran_awal - $kegiatan->anggaran_awal;
            $selisihAnggaran = $request->anggaran - $kegiatan->anggaran;

            // Ambil program terkait
            $program = $kegiatan->program;

            // Jika anggaran_awal bertambah, kurangi dari program
            if ($selisihAnggaranAwal > 0) {
                $program->anggaran -= $selisihAnggaranAwal;
            } elseif ($selisihAnggaranAwal < 0) {
                $program->anggaran += abs($selisihAnggaranAwal);
            }

            // Jika anggaran bertambah, kurangi dari program
            if ($selisihAnggaran > 0) {
                $program->anggaran -= $selisihAnggaran;
            } elseif ($selisihAnggaran < 0) {
                $program->anggaran += abs($selisihAnggaran);
            }

            // Validasi apakah program memiliki cukup anggaran
            if ($program->anggaran < 0) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran program tidak mencukupi.'])
                    ->withInput();
            }

            $program->save();

            // **Update kegiatan**
            $kegiatan->update([
                'program_id' => $request->program_id,
                'bidang_id' => $request->bidang_id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'anggaran_awal' => $request->anggaran_awal,
                'anggaran' => $request->anggaran,
            ]);

            DB::commit();
            return redirect()->route('kegiatan.index')->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }






    public function destroy(Kegiatan $kegiatan)
    {
        DB::beginTransaction();
        try {
            $program = $kegiatan->program;

            // Kembalikan anggaran kegiatan ke program
            $program->anggaran += $kegiatan->anggaran;
            $program->save();

            // Hapus subkegiatan terkait secara permanen (forceDelete)
            $kegiatan->subKegiatan()->forceDelete();

            // Hapus kegiatan
            $kegiatan->delete();

            DB::commit();
            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil dihapus dan anggaran program diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menghapus kegiatan: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus kegiatan.']);
        }
    }


}
