<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
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

            // Menampilkan semua data Program
            $programs = Program::with('skpd', 'bidang')->paginate(10);
        } else {
            // Untuk pengguna selain superadmin, total anggaran dihitung hanya berdasarkan bidang user
            $totalAnggaran = Program::where('bidang_id', $user->bidang_id)->sum('anggaran');

            // Menampilkan data Program sesuai dengan bidang yang dimiliki user
            $programs = Program::where('bidang_id', $user->bidang_id)
                ->with('skpd', 'bidang')
                ->paginate(10);
        }

        // Mengirimkan data ke view
        return view('program.index', compact('programs', 'totalAnggaran'));
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
            $skpd->kurangiAnggaran($request->anggaran);

            Program::create($request->all());

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
            $skpd = $program->skpd;
            $selisihAnggaran = $program->anggaran - $request->anggaran;
            $skpd->tambahAnggaran($selisihAnggaran);

            $program->update($request->all());

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
            $skpd = $program->skpd;
            $skpd->tambahAnggaran($program->anggaran);
            $program->delete();

            DB::commit();
            return redirect()->route('program.index')->with('message', [
                'type' => 'success',
                'content' => 'Program berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat menghapus program: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus program.']);
        }
    }
}
