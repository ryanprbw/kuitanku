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

        $query = Kegiatan::with(['program', 'bidang'])
            ->withSum('subKegiatan as total_realisasi', 'anggaran_awal'); // Ambil total realisasi langsung dari database

        if ($user->role !== 'superadmin') {
            $query->where('bidang_id', $user->bidang_id);
        }

        $kegiatans = $query->paginate(10);

        $kegiatans->setCollection(
            $kegiatans->getCollection()->map(function ($kegiatan) {
                $kegiatan->sisa_anggaran = $kegiatan->anggaran_awal - $kegiatan->anggaran;
                return $kegiatan;
            })
        );

        $totalAnggaran = $query->sum('anggaran');

        $totalRealisasi = SubKegiatan::sum('anggaran_awal');

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

            // Validasi anggaran kegiatan tidak lebih besar dari program
            if ($request->anggaran > $program->anggaran) {
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran kegiatan tidak boleh lebih besar dari anggaran program.'])->withInput();
            }

            // Kurangi anggaran dari program
            $program->kurangiAnggaran($request->anggaran);

            // Simpan kegiatan baru
            Kegiatan::create($request->validated());

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
            $program = $kegiatan->program;

            $selisihAnggaranAwal = $request->anggaran_awal - $kegiatan->anggaran_awal;
            $selisihAnggaran = $request->anggaran - $kegiatan->anggaran;

            if ($request->anggaran > $request->anggaran_awal) {
                return redirect()->back()
                    ->withErrors(['anggaran' => 'Anggaran tidak boleh lebih besar dari anggaran awal.'])
                    ->withInput();
            }

            // Update anggaran di program
            if ($selisihAnggaranAwal > 0) {
                $program->kurangiAnggaran($selisihAnggaranAwal);
            } elseif ($selisihAnggaranAwal < 0) {
                $program->tambahAnggaran(abs($selisihAnggaranAwal));
            }

            if ($selisihAnggaran > 0) {
                $program->kurangiAnggaran($selisihAnggaran);
            } elseif ($selisihAnggaran < 0) {
                $program->tambahAnggaran(abs($selisihAnggaran));
            }

            $kegiatan->update($request->validated());

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

            if (!$program) {
                return redirect()->back()->withErrors(['error' => 'Program tidak ditemukan untuk kegiatan ini.']);
            }

            // Kembalikan anggaran kegiatan ke program
            $program->tambahAnggaran($kegiatan->anggaran);

            // Hapus subkegiatan terkait
            foreach ($kegiatan->subKegiatan as $subKegiatan) {
                $subKegiatan->kodeRekenings()->delete();

                foreach ($subKegiatan->kodeRekenings as $kodeRekening) {
                    $kodeRekening->rincianBelanjaUmum()->delete();
                    $kodeRekening->rincianBelanjaSppd()->delete();
                }

                $subKegiatan->delete();
            }

            // Hapus kegiatan
            $kegiatan->delete();

            DB::commit();
            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan dan semua data terkait berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menghapus kegiatan: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus kegiatan.']);
        }
    }
}
