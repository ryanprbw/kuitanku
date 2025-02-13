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
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $totalAnggaran = Program::sum('anggaran');
            $totalRealisasi = Kegiatan::sum('anggaran');

            $programs = Program::with('skpd', 'bidang')
                ->paginate(10)
                ->through(function ($program) {
                    $program->sisa_anggaran = $program->anggaran_awal - $program->anggaran;
                    $program->total_realisasi = $program->kegiatan()->sum('anggaran_awal'); // Ambil langsung dari relasi
                    return $program;
                });

        } else {
            $totalAnggaran = Program::where('bidang_id', $user->bidang_id)->sum('anggaran');
            $totalRealisasi = Kegiatan::where('bidang_id', $user->bidang_id)->sum('anggaran');

            $programs = Program::where('bidang_id', $user->bidang_id)
                ->with('skpd', 'bidang')
                ->paginate(10)
                ->through(function ($program) {
                    $program->sisa_anggaran = $program->anggaran_awal - $program->anggaran;
                    $program->total_realisasi = $program->kegiatan()->sum('anggaran_awal');
                    return $program;
                });
        }

        return view('program.index', compact('programs', 'totalAnggaran', 'totalRealisasi'));
    }




    public function show(Program $program)
    {
        return view('program.show', compact('program'));
    }

    public function create()
    {
        return view('program.create', [
            'skpds' => Skpd::all(),
            'bidangs' => Bidang::all(),
        ]);
    }

    public function store(ProgramRequest $request)
    {
        DB::beginTransaction();
        try {
            $skpd = Skpd::findOrFail($request->skpd_id);

            if ($request->anggaran > $request->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            $skpd->kurangiAnggaran($request->anggaran);

            $program = Program::create($request->validated());

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
        return view('program.edit', [
            'program' => $program,
            'skpds' => Skpd::all(),
            'bidangs' => Bidang::all(),
        ]);
    }

    public function update(ProgramRequest $request, Program $program)
    {
        DB::beginTransaction();
        try {
            $skpd = $program->skpd;
            $selisihAnggaran = $request->anggaran - $program->anggaran;
            $selisihAnggaranAwal = $request->anggaran_awal - $program->anggaran_awal; // Cek perubahan anggaran awal

            if ($request->anggaran > $request->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            // Jika anggaran awal bertambah, kurangi dari anggaran SKPD
            if ($selisihAnggaranAwal > 0) {
                $skpd->kurangiAnggaran($selisihAnggaranAwal);
            }
            // Jika anggaran awal berkurang, tambahkan kembali ke anggaran SKPD
            elseif ($selisihAnggaranAwal < 0) {
                $skpd->tambahAnggaran(abs($selisihAnggaranAwal));
            }

            // Update anggaran program
            if ($selisihAnggaran < 0) {
                $skpd->tambahAnggaran(abs($selisihAnggaran)); // Jika anggaran dikurangi, tambahkan kembali ke SKPD
            } else {
                $skpd->kurangiAnggaran($selisihAnggaran); // Jika anggaran bertambah, kurangi dari SKPD
            }

            $program->update($request->only(['nama', 'skpd_id', 'bidang_id', 'anggaran', 'anggaran_awal']));

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
            // **Hapus semua kegiatan dan sub-kegiatan sebelum menghapus program**
            foreach ($program->kegiatan as $kegiatan) {
                $kegiatan->subKegiatan()->forceDelete(); // Hapus sub kegiatan
                $kegiatan->forceDelete(); // Hapus kegiatan
            }

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
