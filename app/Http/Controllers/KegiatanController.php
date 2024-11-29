<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'superadmin') {
            $kegiatans = Kegiatan::with(['program', 'bidang'])->paginate(10);
        } else {
            $kegiatans = Kegiatan::where('bidang_id', $user->bidang_id)
                ->with(['program', 'bidang'])
                ->paginate(10);
        }

        return view('kegiatan.index', compact('kegiatans'));
    }

    public function create()
    {
        $programs = Program::all();
        $bidangs = Bidang::all();
        return view('kegiatan.create', compact('programs', 'bidangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'nama_kegiatan' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $program = Program::findOrFail($request->program_id);

            if ($program->anggaran < $request->anggaran) {
                return redirect()->back()->withErrors(['error' => 'Anggaran program tidak mencukupi.'])->withInput();
            }

            $program->anggaran -= $request->anggaran;
            $program->save();

            Kegiatan::create($request->all());

            DB::commit();

            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil ditambahkan dan anggaran program diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
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
            'anggaran' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        try {
            $program = $kegiatan->program;

            // Kembalikan anggaran lama kegiatan ke program
            $program->anggaran += $kegiatan->anggaran;

            // Validasi anggaran baru mencukupi
            if ($program->anggaran < $request->anggaran) {
                return redirect()->back()->withErrors(['error' => 'Anggaran program tidak mencukupi untuk pembaruan.'])->withInput();
            }

            // Kurangi anggaran baru dari program
            $program->anggaran -= $request->anggaran;
            $program->save();

            // Perbarui data kegiatan
            $kegiatan->update($request->all());

            DB::commit();

            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil diperbarui dan anggaran program diperbarui.',
            ]);
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

            $kegiatan->delete();

            DB::commit();

            return redirect()->route('kegiatan.index')->with('message', [
                'type' => 'success',
                'content' => 'Kegiatan berhasil dihapus dan anggaran program diperbarui.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus kegiatan.']);
        }
    }
}
