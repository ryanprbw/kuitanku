<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaSppd;
use Illuminate\Http\Request;

class LaporanSppdController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Menghitung total anggaran yang digunakan
        $totalAnggaran = RincianBelanjaSppd::when($user->role !== 'superadmin', function ($query) use ($user) {
            $query->where('bidang_id', $user->bidang_id);
        })
            ->sum('sebesar');

        // Mengambil rincian belanja dengan relasi yang diperlukan
        $rincianBelanja = RincianBelanjaSppd::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->get()
            ->groupBy(function ($item) {
                // Menambahkan nama_bidang ke dalam kombinasi pengelompokkan
                $programId = $item->program ? $item->program->id : null;
                $programNamaBidang = $item->program ? $item->program->nama_bidang : null;
                $kegiatanId = $item->kegiatan ? $item->kegiatan->id : null;
                $subKegiatanId = $item->subKegiatan ? $item->subKegiatan->id : null;
                $kodeRekeningId = $item->kodeRekening ? $item->kodeRekening->id : null;

                return $programId . '-' . $programNamaBidang . '-' . $kegiatanId . '-' . $subKegiatanId . '-' . $kodeRekeningId;
            });

        return view('laporan_sppd.index', compact('rincianBelanja', 'totalAnggaran'));
    }
}
