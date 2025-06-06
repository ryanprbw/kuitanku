<?php

namespace App\Http\Controllers;

use App\Models\RincianBelanjaUmum;
use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\KodeRekening;
use App\Models\KepalaDinas;
use App\Models\Pptk;
use App\Models\Bendahara;
use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;

class RincianBelanjaUmumController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Handling the search query
        $search = $request->input('search');

        // Menghitung total anggaran yang digunakan
        $totalAnggaran = RincianBelanjaUmum::when($user->role !== 'superadmin', function ($query) use ($user) {
            $query->where('bidang_id', $user->bidang_id);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('untuk_pengeluaran', 'like', '%' . $search . '%')
                    ->orWhereHas('program', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama_kegiatan', 'like', '%' . $search . '%');
                    })
                    // Pencarian berdasarkan nama bidang
                    ->orWhereHas('bidang', function ($query) use ($search) {
                        $query->where('nama_bidang', 'like', '%' . $search . '%');
                    });
            })
            ->sum('sebesar');

        // Mengambil rincian belanja dengan relasi yang diperlukan
        $rincianBelanja = RincianBelanjaUmum::with(['program', 'kegiatan', 'subKegiatan', 'kodeRekening', 'kepalaDinas', 'pptk', 'bendahara', 'penerima'])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->when($search, function ($query) use ($search) {
                $query->where('untuk_pengeluaran', 'like', '%' . $search . '%')
                    ->orWhereHas('program', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama_kegiatan', 'like', '%' . $search . '%');
                    })
                    // Pencarian berdasarkan nama bidang
                    ->orWhereHas('bidang', function ($query) use ($search) {
                        $query->where('nama_bidang', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('rincian_belanja_umum.index', compact('rincianBelanja', 'totalAnggaran', 'search'));
    }



    public function create()
    {
        $user = auth()->user(); // Ambil data pengguna yang sedang login

        // Ambil data berdasarkan bidang_id pengguna yang login
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();

        // Filter kode_rekenings berdasarkan bidang_id pengguna
        $kode_rekenings = KodeRekening::where('bidang_id', $user->bidang_id)->get();

        $kepala_dinas = KepalaDinas::all();
        $pptks = Pptk::all();
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
            'bulan' => 'nullable|string|max:20',
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
    public function edit($id)
    {
        $user = auth()->user();
        $rincianBelanja = RincianBelanjaUmum::findOrFail($id);

        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::where('bidang_id', $user->bidang_id)->get();
        $kepala_dinas = KepalaDinas::all();
        $pptks = Pptk::all();
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
            'bulan' => 'nullable|string|max:20',
            'kepala_dinas_id' => 'required|exists:kepala_dinas,id',
            'pptk_id' => 'required|exists:pptks,id',
            'bendahara_id' => 'required|exists:bendaharas,id',
            'penerima_id' => 'required|exists:pegawais,id',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['bruto'] = $request->sebesar;
            $data['pbjt'] = $request->dpp * 0.1;
            $data['total_pajak'] = ($request->pph21 ?? 0) + ($request->pph22 ?? 0) + ($request->pph23 ?? 0) + ($request->ppn ?? 0);
            $data['netto'] = $request->sebesar - $data['total_pajak'];
            $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);

            $kodeRekeningLama = KodeRekening::where('id', $rincianBelanja->kode_rekening_id)->lockForUpdate()->firstOrFail();
            $kodeRekeningBaru = KodeRekening::where('id', $request->kode_rekening_id)->lockForUpdate()->firstOrFail();

            if ($kodeRekeningLama->id === $kodeRekeningBaru->id) {
                // Rekening tidak berubah
                $selisih = $rincianBelanja->sebesar - $request->sebesar;

                if ($selisih > 0) {
                    $kodeRekeningBaru->anggaran += $selisih;
                } elseif ($kodeRekeningBaru->anggaran < abs($selisih)) {
                    return back()->withErrors(['anggaran' => 'Anggaran tidak mencukupi untuk perubahan.'])->withInput();
                } else {
                    $kodeRekeningBaru->anggaran -= abs($selisih);
                }

                $kodeRekeningBaru->save();
            } else {
                // Rekening diganti
                // Kembalikan ke rekening lama
                $kodeRekeningLama->anggaran += $rincianBelanja->sebesar;
                $kodeRekeningLama->save();

                // Kurangi dari rekening baru
                if ($kodeRekeningBaru->anggaran < $request->sebesar) {
                    return back()->withErrors(['anggaran' => 'Anggaran tidak mencukupi pada rekening baru.'])->withInput();
                }

                $kodeRekeningBaru->anggaran -= $request->sebesar;
                $kodeRekeningBaru->save();
            }

            $rincianBelanja->update($data);
            DB::commit();
            return redirect()->route('rincian_belanja_umum.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $rincianBelanja = RincianBelanjaUmum::findOrFail($id);

            $kodeRekening = KodeRekening::lockForUpdate()->findOrFail($rincianBelanja->kode_rekening_id);
            $kodeRekening->anggaran += $rincianBelanja->sebesar;
            $kodeRekening->save();

            $rincianBelanja->delete();

            DB::commit();
            return redirect()->route('rincian_belanja_umum.index')->with('success', 'Data berhasil dihapus dan anggaran dikembalikan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
            $temp = $this->terbilang((int) ($angka / 10)) . " Puluh " . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $temp = "Seratus " . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $temp = $this->terbilang((int) ($angka / 100)) . " Ratus " . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $temp = "Seribu " . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $temp = $this->terbilang((int) ($angka / 1000)) . " Ribu " . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $temp = $this->terbilang((int) ($angka / 1000000)) . " Juta " . $this->terbilang($angka % 1000000);
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
