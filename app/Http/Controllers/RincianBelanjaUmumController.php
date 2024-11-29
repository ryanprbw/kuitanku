<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\KodeRekening;
use App\Models\KepalaDinas;
use App\Models\PPTK;
use App\Models\Bendahara;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RincianBelanjaUmumController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $rincianBelanja = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'kepalaDinas', 'pptk', 'bendahara', 'penerima'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->paginate(10);

        return view('rincian_belanja_umum.index', compact('rincianBelanja'));
    }

    public function create()
    {
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::all();
        $kepala_dinas = KepalaDinas::all();
        $pptks = PPTK::all();
        $bendaharas = Bendahara::all();
        $pegawais = Pegawai::all();

        return view('rincian_belanja_umum.create', compact(
            'programs',
            'kegiatans',
            'sub_kegiatans',
            'kode_rekenings',
            'kepala_dinas',
            'pptks',
            'bendaharas',
            'pegawais'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
            'kode_rekening_id' => 'required|exists:kode_rekenings,id',
            'sebesar' => 'required|numeric|min:0',
            'untuk_pengeluaran' => 'required|string|max:255',
            'dpp' => 'nullable|numeric|min:0',
            'pph21' => 'nullable|numeric|min:0',
            'pph22' => 'nullable|numeric|min:0',
            'pph23' => 'nullable|numeric|min:0',
            'ppn' => 'nullable|numeric|min:0',
            'bulan' => 'required|string|max:20',
            'kepala_dinas_id' => 'required|exists:kepala_dinas,id',
            'pptk_id' => 'required|exists:pptks,id',
            'bendahara_id' => 'required|exists:bendaharas,id',
            'penerima_id' => 'required|exists:pegawais,id',
        ]);

        $data = $request->all();
        $data['bidang_id'] = auth()->user()->bidang_id;
        $data['bruto'] = $request->sebesar;
        $data['pbjt'] = $request->dpp * 0.1;
        $data['total_pajak'] = ($request->pph21 ?? 0) + ($request->pph22 ?? 0) + ($request->pph23 ?? 0) + ($request->ppn ?? 0);
        $data['netto'] = $request->sebesar - $data['total_pajak'];
        $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);

        $kodeRekening = KodeRekening::findOrFail($request->kode_rekening_id);

        if ($kodeRekening->anggaran < $request->sebesar) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Kode Rekening tidak mencukupi.'])->withInput();
        }

        $kodeRekening->anggaran -= $request->sebesar;
        $kodeRekening->save();

        RincianBelanjaUmum::create($data);

        return redirect()->route('rincian_belanja_umum.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $rincian = RincianBelanjaUmum::with([
            'program',
            'kegiatan',
            'subKegiatan',
            'kodeRekening',
            'kepalaDinas',
            'pptk',
            'bendahara',
            'penerima'
        ])->findOrFail($id);

        return view('rincian_belanja_umum.show', compact('rincian'));
    }

    public function edit($id)
    {
        $rincianBelanja = RincianBelanjaUmum::findOrFail($id);
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::all();
        $kepala_dinas = KepalaDinas::all();
        $pptks = PPTK::all();
        $bendaharas = Bendahara::all();
        $pegawais = Pegawai::all();

        return view('rincian_belanja_umum.edit', compact(
            'rincianBelanja',
            'programs',
            'kegiatans',
            'sub_kegiatans',
            'kode_rekenings',
            'kepala_dinas',
            'pptks',
            'bendaharas',
            'pegawais'
        ));
    }

    public function update(Request $request, $id)
    {
        $rincianBelanja = RincianBelanjaUmum::findOrFail($id);

        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
            'kode_rekening_id' => 'required|exists:kode_rekenings,id',
            'sebesar' => 'required|numeric|min:0',
            'untuk_pengeluaran' => 'required|string|max:255',
            'dpp' => 'nullable|numeric|min:0',
            'pph21' => 'nullable|numeric|min:0',
            'pph22' => 'nullable|numeric|min:0',
            'pph23' => 'nullable|numeric|min:0',
            'ppn' => 'nullable|numeric|min:0',
            'bulan' => 'required|string|max:20',
            'kepala_dinas_id' => 'required|exists:kepala_dinas,id',
            'pptk_id' => 'required|exists:pptks,id',
            'bendahara_id' => 'required|exists:bendaharas,id',
            'penerima_id' => 'required|exists:pegawais,id',
        ]);

        $data = $request->all();
        $data['bruto'] = $request->sebesar;
        $data['pbjt'] = $request->dpp * 0.1;
        $data['total_pajak'] = ($request->pph21 ?? 0) + ($request->pph22 ?? 0) + ($request->pph23 ?? 0) + ($request->ppn ?? 0);
        $data['netto'] = $request->sebesar - $data['total_pajak'];
        $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);

        $kodeRekening = KodeRekening::findOrFail($request->kode_rekening_id);

        $selisih = $rincianBelanja->sebesar - $request->sebesar;

        if ($selisih > 0) {
            $kodeRekening->anggaran += $selisih;
        } elseif ($kodeRekening->anggaran < abs($selisih)) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Kode Rekening tidak mencukupi untuk perubahan.'])->withInput();
        } else {
            $kodeRekening->anggaran -= abs($selisih);
        }

        $kodeRekening->save();
        $rincianBelanja->update($data);

        return redirect()->route('rincian_belanja_umum.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rincianBelanja = RincianBelanjaUmum::findOrFail($id);

        $kodeRekening = KodeRekening::findOrFail($rincianBelanja->kode_rekening_id);
        $kodeRekening->anggaran += $rincianBelanja->sebesar;
        $kodeRekening->save();

        $rincianBelanja->delete();

        return redirect()->route('rincian_belanja_umum.index')->with('success', 'Data berhasil dihapus.');
    }

    private function terbilang($angka)
    {
        
        $angka = abs($angka);
        $huruf = [" ", " Satu", " Dua", " Tiga", " Empat", " Lima", " Enam", " Tujuh", " Delapan", " Sembilan", " Sepuluh", " Sebelas"];
        $temp = "";
    
        if ($angka < 12) {
            $temp = $huruf[$angka];
        } elseif ($angka < 20) {
            $temp = $this->terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            $temp = $this->terbilang((int)($angka / 10)) . " Puluh " . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $temp = "Seratus " . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $temp = $this->terbilang((int)($angka / 100)) . " Ratus " . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $temp = "Seribu " . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $temp = $this->terbilang((int)($angka / 1000)) . " Ribu " . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $temp = $this->terbilang((int)($angka / 1000000)) . " Juta " . $this->terbilang($angka % 1000000);
        }
    
        // Gunakan trim() untuk menghilangkan spasi ekstra
        return trim($temp);
    }
    



    private function terbilangRupiah($angka)
    {
        return ucwords($this->terbilang($angka)) . " Rupiah";
    }

    public function exportDetailPdf($id)
{
    $rincian = RincianBelanjaUmum::with([
        'program',
        'kegiatan',
        'subKegiatan',
        'kodeRekening',
        'kepalaDinas',
        'pptk',
        'bendahara',
        'penerima',
        'bidang' // Tambahkan relasi bidang
    ])->findOrFail($id);

    $pdf = Pdf::loadView('rincian_belanja_umum.pdf_detail', compact('rincian'))
    ->setPaper([0, 0, 612, 936]); // 8.5 x 13 inch in points (1 inch = 72 points)

    return $pdf->stream("rincian-belanja-umum-{$rincian->id}.pdf");
}


}
