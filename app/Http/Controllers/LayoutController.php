<?php

namespace App\Http\Controllers;

use App\Models\Bendahara;
use App\Models\Kegiatan;
use App\Models\KepalaDinas;
use App\Models\KodeRekening;
use App\Models\Pegawai;
use App\Models\Pptk;
use App\Models\Program;
use App\Models\RincianBelanjaSppd;
use App\Models\RincianBelanjaUmum;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;

class LayoutController extends Controller
{

    public function index()
    {
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::all();
        $kepala_dinas = KepalaDinas::all();
        $pptks = Pptk::all();
        $bendaharas = Bendahara::all();
        $pegawais = Pegawai::all();
        $rincianbelanjaumum = RincianBelanjaUmum::all();
        $rincianbelanjasppd = RincianBelanjaSppd::all();

        $jumlahPegawai = Pegawai::count();

        return view('dashboard', compact(
            'programs',
            'kegiatans',
            'sub_kegiatans',
            'kode_rekenings',
            'kepala_dinas',
            'pptks',
            'bendaharas',
            'pegawais',
            'rincianbelanjaumum',
            'rincianbelanjasppd',
            'jumlahPegawai'
        ));
    }
}
