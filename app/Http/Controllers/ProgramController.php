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

        $query = Program::with(['skpd', 'bidang'])
            ->withSum('kegiatan as total_realisasi', 'anggaran_awal'); // Hitung total realisasi langsung di query

        if ($user->role !== 'superadmin') {
            $query->where('bidang_id', $user->bidang_id);
        }

        $programs = $query->paginate(10);

        // Pastikan pagination tetap berfungsi setelah modifikasi data
        $programs->setCollection(
            $programs->getCollection()->map(function ($program) {
                $program->sisa_anggaran = $program->anggaran_awal - $program->anggaran;
                return $program;
            })
        );

        $totalAnggaran = $query->sum('anggaran');
        $totalRealisasi = Kegiatan::sum('anggaran_awal');


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

            if ($skpd->anggaran < $request->anggaran) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran SKPD tidak mencukupi.'])
                    ->withInput();
            }

            // Kurangi anggaran dari SKPD
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
            $selisihAnggaranAwal = $request->anggaran_awal - $program->anggaran_awal;

            if ($request->anggaran > $request->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            // Jika anggaran awal berubah, update SKPD
            if ($selisihAnggaranAwal > 0) {
                if ($skpd->anggaran < $selisihAnggaranAwal) {
                    return redirect()->back()->withErrors(['anggaran_awal' => 'Anggaran SKPD tidak mencukupi.'])->withInput();
                }
                $skpd->kurangiAnggaran($selisihAnggaranAwal);
            } elseif ($selisihAnggaranAwal < 0) {
                $skpd->tambahAnggaran(abs($selisihAnggaranAwal));
            }

            // Update anggaran program dan kembalikan atau kurangi dari SKPD
            if ($selisihAnggaran < 0) {
                $skpd->tambahAnggaran(abs($selisihAnggaran));
            } else {
                if ($skpd->anggaran < $selisihAnggaran) {
                    return redirect()->back()->withErrors(['anggaran' => 'Anggaran SKPD tidak mencukupi.'])->withInput();
                }
                $skpd->kurangiAnggaran($selisihAnggaran);
            }

            // Perbarui program
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
            foreach ($program->kegiatan as $kegiatan) {
                $kegiatan->subKegiatan()->delete(); // Soft delete sub-kegiatan
                $kegiatan->delete(); // Soft delete kegiatan
            }

            // Kembalikan anggaran ke SKPD sebelum menghapus program
            $program->skpd->tambahAnggaran($program->anggaran);

            // Hapus program (gunakan `delete()` untuk soft delete, atau `forceDelete()` untuk permanent delete)
            $program->delete();

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
