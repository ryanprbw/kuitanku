<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\Skpd;
use App\Http\Requests\ProgramRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProgramController extends Controller
{
    public function index()
    {
        // Mendapatkan data user yang login
        $user = auth()->user();

        // Menghitung total anggaran sesuai dengan role user
        if ($user->role === 'superadmin') {
            // Untuk superadmin, total anggaran dihitung dari seluruh Program
            $totalAnggaran = Program::sum('anggaran');

            // Total realisasi untuk superadmin, dihitung dari seluruh Kegiatan
            $totalRealisasi = Kegiatan::sum('anggaran');

            // Menampilkan semua data Program
            $programs = Program::with('skpd', 'bidang')
                ->paginate(10)
                ->through(function ($program) {
                    // Menghitung sisa anggaran per program
                    $program->sisa_anggaran = $program->anggaran_awal - $program->anggaran;

                    // Menghitung total realisasi untuk masing-masing program
                    $program->total_realisasi = Kegiatan::where('program_id', $program->id)->sum('anggaran');

                    return $program;
                });

        } else {
            // Untuk pengguna selain superadmin, total anggaran dihitung hanya berdasarkan bidang user
            $totalAnggaran = Program::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Total realisasi berdasarkan bidang user
            $totalRealisasi = Kegiatan::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Menampilkan data Program sesuai dengan bidang yang dimiliki user
            $programs = Program::where('bidang_id', $user->bidang_id)
                ->with('skpd', 'bidang')
                ->paginate(10)
                ->through(function ($program) {
                    // Menghitung sisa anggaran per program
                    $program->sisa_anggaran = $program->anggaran_awal - $program->anggaran;

                    // Menghitung total realisasi untuk masing-masing program
                    $program->total_realisasi = Kegiatan::where('program_id', $program->id)->sum('anggaran');

                    return $program;
                });
        }

        // Mengirimkan data ke view
        return view('program.index', compact('programs', 'totalAnggaran', 'totalRealisasi'));
    }



    public function show(Program $program)
    {
        return view('program.show', compact('program'));
    }


    public function create()
    {


        $skpds = Skpd::all();
        $bidangs = Bidang::all();
        return view('program.create', compact('skpds', 'bidangs'));
    }

    public function store(ProgramRequest $request)
    {
        DB::beginTransaction();
        try {
            $skpd = Skpd::findOrFail($request->skpd_id);

            // Periksa apakah anggaran lebih besar dari anggaran awal
            if ($request->anggaran > $request->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            // Kurangi anggaran SKPD
            $skpd->kurangiAnggaran($request->anggaran);

            // Simpan program dengan anggaran_awal
            Program::create([
                'nama' => $request->nama,
                'skpd_id' => $request->skpd_id,
                'bidang_id' => $request->bidang_id,
                'anggaran_awal' => $request->anggaran_awal,
                'anggaran' => $request->anggaran,
            ]);

            DB::commit();
            return redirect()->route('program.index')->with('message', [
                'type' => 'success',
                'content' => 'Program berhasil ditambahkan.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menyimpan program: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }



    public function edit(Program $program)
    {
        $skpds = Skpd::all();
        $bidangs = Bidang::all();
        return view('program.edit', compact('program', 'skpds', 'bidangs'));
    }

    public function update(ProgramRequest $request, Program $program)
    {
        DB::beginTransaction();
        try {
            // Dapatkan SKPD yang terhubung dengan program
            $skpd = $program->skpd;

            // Hitung selisih anggaran
            $selisihAnggaran = $request->anggaran - $program->anggaran;

            // Periksa apakah anggaran lebih besar dari anggaran_awal
            if ($request->anggaran > $program->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            if ($selisihAnggaran < 0) {
                // Jika anggaran baru lebih kecil, kembalikan anggaran ke SKPD
                $skpd->tambahAnggaran(abs($selisihAnggaran));
            } else {
                // Jika anggaran baru lebih besar, kurangi anggaran dari SKPD
                $skpd->kurangiAnggaran($selisihAnggaran);
            }

            // Update program hanya dengan data yang diizinkan
            $program->update($request->only([
                'nama',
                'skpd_id',
                'bidang_id',
                'anggaran'
            ]));

            DB::commit();
            return redirect()->route('program.index')->with('message', [
                'type' => 'success',
                'content' => 'Program berhasil diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat memperbarui program: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }



    public function destroy(Program $program)
    {
        DB::beginTransaction();
        try {
            // Hapus semua kegiatan terkait secara permanen
            $program->kegiatan()->forceDelete();

            // Kembalikan anggaran ke SKPD sebelum menghapus program
            $skpd = $program->skpd;
            $skpd->tambahAnggaran($program->anggaran);

            // Hapus program secara permanen
            $program->forceDelete();

            DB::commit();
            return redirect()->route('program.index')->with('message', [
                'type' => 'success',
                'content' => 'Program dan semua Kegiatan terkait berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menghapus program: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus program.']);
        }
    }

}
