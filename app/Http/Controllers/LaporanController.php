<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Menghitung total anggaran yang digunakan
        $totalAnggaran = RincianBelanjaUmum::when($user->role !== 'superadmin', function ($query) use ($user) {
            $query->where('bidang_id', $user->bidang_id);
        })
            ->sum('sebesar');

        // Mengambil rincian belanja dengan relasi yang diperlukan
        $rincianBelanja = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->get()
            ->groupBy(function ($item) {
                // Menambahkan nama_bidang ke dalam kombinasi pengelompokkan
                return $item->program->id . '-' . $item->program->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
            });

        return view('laporan.index', compact('rincianBelanja', 'totalAnggaran'));
    }
}
