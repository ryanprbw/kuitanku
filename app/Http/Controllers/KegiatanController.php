<?php

namespace App\Http\Controllers;

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
                        ->sum('anggaran'); // Sum anggaran dari SubKegiatan yang terkait dengan kegiatan
    
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
                        ->sum('anggaran'); // Sum anggaran dari SubKegiatan yang terkait dengan kegiatan
    
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

    public function update(KegiatanRequest $request, Kegiatan $kegiatan)
    {
        DB::beginTransaction();
        try {
            $program = $kegiatan->program;
            $selisihAnggaran = $request->anggaran - $kegiatan->anggaran;

            // Validasi anggaran yang lebih besar dari anggaran awal
            if ($request->anggaran > $kegiatan->anggaran_awal) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])->withInput();
            }

            // Jika anggaran baru lebih kecil, tambahkan kembali anggaran ke program
            if ($selisihAnggaran < 0) {
                $program->anggaran += abs($selisihAnggaran);
            } else {
                $program->anggaran -= $selisihAnggaran;
            }
            $program->save();

            // Update data kegiatan
            $kegiatan->update($request->only([
                'program_id',
                'bidang_id',
                'nama_kegiatan',
                'anggaran',
            ]));

            DB::commit();
            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil diperbarui dan anggaran program diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat memperbarui kegiatan: ' . $e->getMessage(), ['exception' => $e]);
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
