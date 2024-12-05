<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Mengambil semua rincian belanja umum beserta program, kegiatan, sub kegiatan, kode rekening, dan bidang
        $rincianBelanjaUmum = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->get()
            ->groupBy(function ($item) {
                // Menambahkan nama_bidang ke dalam kombinasi pengelompokkan
                return $item->program->id . '-' . $item->program->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
            });

        return view('laporan.index', compact('rincianBelanjaUmum'));
    }
}
