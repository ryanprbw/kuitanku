<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Mengambil semua rincian belanja umum beserta program, kegiatan, sub kegiatan, dan kode rekening
        // Mengambil data dan mengelompokkan berdasarkan kombinasi yang diinginkan
        $rincianBelanjaUmum = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening'])
            ->get()
            ->groupBy(function ($item) {
                return $item->program->id . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
            });


        return view('laporan.index', compact('rincianBelanjaUmum'));
    }
}
