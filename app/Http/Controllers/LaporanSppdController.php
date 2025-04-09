<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use App\Models\Bidang;
use App\Models\KepalaDinas;
use App\Models\RincianBelanjaSppd;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanSppdController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $bidangId = $request->input('bidang');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $rincianBelanja = RincianBelanjaSppd::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->when($bidangId, function ($query) use ($bidangId) {
                $query->where('bidang_id', $bidangId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when(!$startDate && $endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->program->id . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
            });

        $totalAnggaran = $rincianBelanja->sum(fn($group) => $group->sum('anggaran'));
        $totalRincian = $rincianBelanja->sum(fn($group) => $group->count());

        $bidangOptions = Bidang::all();

        return view('laporan_sppd.index', compact('rincianBelanja', 'totalAnggaran', 'totalRincian', 'bidangOptions'));
    }
    public function cetak(Request $request)
    {
        $user = auth()->user();
        $bidangId = $request->input('bidang');
        $startDate = $request->input('start_date'); // ← ini harus didefinisikan dulu
        $endDate = $request->input('end_date');

        $kadis = KepalaDinas::first();
        $bendahara = Bendahara::first();

        $query = RincianBelanjaSppd::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', fn($q) => $q->where('bidang_id', $user->bidang_id))
            ->when($bidangId, fn($q) => $q->where('bidang_id', $bidangId))
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate));

        $rincianBelanja = $query->get()->groupBy(
            fn($item) => $item->program->id . '-' . $item->bidang->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id
        );

        $totalAnggaran = $rincianBelanja->sum(fn($group) => $group->sum('anggaran')); // Lebih aman daripada ulang query

        $pdf = Pdf::loadView('laporan_sppd.cetak', compact(
            'rincianBelanja',
            'totalAnggaran',
            'startDate',
            'endDate',
            'kadis',
            'bendahara'
        ))
            ->setPaper([0, 0, 330, 210], 'landscape')
            ->set_option('isHtml5ParserEnabled', true)
            ->set_option('isPhpEnabled', true)
            ->set_option('defaultFont', 'Arial');

        return $pdf->stream('laporan.pdf');
    }

}
