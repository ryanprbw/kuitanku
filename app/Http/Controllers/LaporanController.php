<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use App\Models\KepalaDinas;
use App\Models\RincianBelanjaUmum;
use App\Models\Bidang; // Model Bidang
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use function React\Promise\all;

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

        $totalRincian = $rincianBelanja->sum(fn($group) => $group->count());


        // Ambil data untuk filter bidang
        $bidangOptions = Bidang::all();

        return view('laporan.index', compact('rincianBelanja', 'totalAnggaran', 'bidangOptions', 'totalRincian'));
    }


    // Method untuk cetak laporan





    public function cetak(Request $request)
    {
        $user = auth()->user();
        $bidangId = $request->input('bidang');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kadis = KepalaDinas::first(); // Ambil satu data kepala dinas
        $bendahara = Bendahara::first(); // Ambil satu data bendahara


        $query = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'bidang'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->when($bidangId, function ($query) use ($bidangId) {
                $query->where('bidang_id', $bidangId);
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            });

        $rincianBelanja = $query->get()->groupBy(
            fn($item) => $item->program->id . '-' . $item->bidang->nama_bidang . '-' . $item->kegiatan->id . '-' . $item->subKegiatan->id . '-' . $item->kodeRekening->id
        );

        $totalAnggaran = $query->sum('anggaran');

        $pdf = Pdf::loadView('laporan.cetak', compact('rincianBelanja', 'totalAnggaran', 'startDate', 'endDate', 'kadis', 'bendahara'))
            ->setPaper([0, 0, 330, 210], 'landscape')
            ->set_option('isHtml5ParserEnabled', true)
            ->set_option('isPhpEnabled', true)
            ->set_option('defaultFont', 'Arial');

        return $pdf->stream('laporan.pdf');
    }




}
