<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use App\Models\Bidang; // Model Bidang
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Menangani Filter Berdasarkan Bidang, Tanggal Mulai dan Tanggal Selesai
        $bidangId = $request->input('bidang');
        $startDate = $request->input('start_date'); // Tanggal mulai
        $endDate = $request->input('end_date'); // Tanggal selesai

        // Filter berdasarkan bidang dan tanggal (range tanggal berdasarkan created_at)
        $rincianBelanja = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->when($bidangId, function ($query) use ($bidangId) {
                $query->where('bidang_id', $bidangId);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]); // Rentang tanggal
            })
            ->when($startDate && !$endDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate); // Hanya tanggal mulai
            })
            ->when(!$startDate && $endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate); // Hanya tanggal selesai
            })
            ->get()
            ->groupBy(function ($item) {
                return $item->program->id . '-' . $item->program->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
            });

        // Total anggaran yang digunakan
        $totalAnggaran = $rincianBelanja->sum(function ($group) {
            return $group->sum('anggaran');
        });

        // Ambil data untuk filter bidang
        $bidangOptions = Bidang::all();

        return view('laporan.index', compact('rincianBelanja', 'totalAnggaran', 'bidangOptions'));
    }


    // Method untuk cetak laporan
    public function cetak(Request $request)
    {
        $user = auth()->user();

        // Menyusun query yang sama dengan filter
        $query = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            });

        // Filter berdasarkan Bidang jika dipilih
        if ($request->has('bidang_id') && $request->bidang_id != '') {
            $query->where('bidang_id', $request->bidang_id);
        }

        // Filter berdasarkan rentang bulan (created_at)
        if ($request->has('bulan_start') && $request->has('bulan_end')) {
            $bulanStart = $request->bulan_start . '-01';
            $bulanEnd = $request->bulan_end . '-31';

            $query->whereBetween('created_at', [$bulanStart, $bulanEnd]);
        }

        // Mengambil rincian belanja untuk dicetak
        $rincianBelanja = $query->get()->groupBy(function ($item) {
            return $item->program->id . '-' . $item->program->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id;
        });

        // Menghitung total anggaran untuk cetak
        $totalAnggaran = $query->sum('sebesar');

        // Cetak PDF (gunakan library seperti barryvdh/laravel-dompdf)
        $pdf = Pdf::loadView('laporan.cetak', compact('rincianBelanja', 'totalAnggaran'));
        return $pdf->download('laporan.pdf');
    }
}
