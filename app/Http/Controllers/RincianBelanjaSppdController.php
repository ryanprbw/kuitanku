<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Kegiatan;
use App\Models\SubKegiatan;
use App\Models\KodeRekening;
use App\Models\KepalaDinas;
use App\Models\Pptk;
use App\Models\Bendahara;
use App\Models\Pegawai;
use App\Models\RincianBelanjaSppd;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;

class RincianBelanjaSppdController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Handling the search query
        $search = $request->input('search');

        // Menghitung total anggaran yang digunakan
        $totalAnggaran = RincianBelanjaSppd::when($user->role !== 'superadmin', function ($query) use ($user) {
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

        $rincianSppd = RincianBelanjaSppd::with([
            'program',
            'kegiatan',
            'subKegiatan',
            'kodeRekening',
            'kepalaDinas',
            'pptk',
            'bendahara',
            'penerima'
        ])
            ->when($user->role !== 'superadmin', function ($query) use ($user) {
                $query->where('bidang_id', $user->bidang_id);
            })
            ->when($search, function ($query) use ($search, $user) {
                $query->where('untuk_pengeluaran', 'like', '%' . $search . '%')
                    ->orWhereHas('program', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama_kegiatan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('bidang', function ($query) use ($search) {
                        $query->where('nama_bidang', 'like', '%' . $search . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(50);


        return view('rincian_belanja_sppd.index', compact('rincianSppd', 'totalAnggaran', 'search'));
    }



    public function create()
    {
        $user = auth()->user();
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::where('bidang_id', $user->bidang_id)->get();
        $kepala_dinas = KepalaDinas::all();
        $pptks = Pptk::all();
        $bendaharas = Bendahara::all();
        $pegawais = Pegawai::all();
        $kepala_dinas = KepalaDinas::orderBy('id', 'asc')->get();
        $latest_kepala_dinas_id = KepalaDinas::latest()->value('id'); // Ambil ID terbaru
        $pptks = PPTK::all();
        $default_pptk_id = 4; // Set default ID 4
        $bendaharas = Bendahara::all();
        $default_bendahara_id = 3; // ID Default Bendahara



        return view('rincian_belanja_sppd.create', compact(
            'programs',
            'kegiatans',
            'sub_kegiatans',
            'kode_rekenings',
            'kepala_dinas',
            'pptks',
            'bendaharas',
            'pegawais',
            'latest_kepala_dinas_id',
            'default_pptk_id',
            'default_bendahara_id'
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
            'nomor_st' => 'required|string',
            'tanggal_st' => 'required|date',
            'nomor_spd' => 'required|string',
            'tanggal_spd' => 'required|date',
            'bulan' => 'nullable|string|max:20',
            'kepala_dinas_id' => 'required|exists:kepala_dinas,id',
            'pptk_id' => 'required|exists:pptks,id',
            'bendahara_id' => 'required|exists:bendaharas,id',
            'penerima_id' => 'required|exists:pegawais,id',
        ]);

        $data = $request->all();
        $data['bidang_id'] = auth()->user()->bidang_id;
        $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);
        $data['bulan'] = $request->bulan ?: null;
        // Mencari Kode Rekening yang terkait
        $kodeRekening = KodeRekening::findOrFail($request->kode_rekening_id);

        // Mengecek apakah anggaran mencukupi
        if ($kodeRekening->anggaran < $request->sebesar) {
            return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Kode Rekening tidak mencukupi.'])->withInput();
        }

        // Kurangi anggaran pada Kode Rekening
        $kodeRekening->anggaran -= $request->sebesar;

        // Simpan perubahan anggaran
        $kodeRekening->save();

        // Menyimpan rincian belanja
        RincianBelanjaSppd::create($data);

        return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil ditambahkan.');
    }


    public function show($id)
    {
        $rincianSppd = RincianBelanjaSppd::with([
            'program',
            'kegiatan',
            'subKegiatan',
            'kodeRekening',
            'kepalaDinas',
            'pptk',
            'bendahara',
            'penerima',
        ])->findOrFail($id);

        return view('rincian_belanja_sppd.show', compact('rincianSppd'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $rincianSppd = RincianBelanjaSppd::findOrFail($id);
        $programs = Program::all();
        $kegiatans = Kegiatan::all();
        $sub_kegiatans = SubKegiatan::all();
        $kode_rekenings = KodeRekening::where('bidang_id', $user->bidang_id)->get();
        $kepala_dinas = KepalaDinas::all();
        $pptks = Pptk::all();
        $bendaharas = Bendahara::all();
        $pegawais = Pegawai::all();

        return view('rincian_belanja_sppd.edit', compact(
            'rincianSppd',
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
        DB::beginTransaction();
        try {
            $rincianSppd = RincianBelanjaSppd::findOrFail($id);

            // Validasi input
            $request->validate([
                'program_id' => 'required|exists:programs,id',
                'kegiatan_id' => 'required|exists:kegiatans,id',
                'sub_kegiatan_id' => 'required|exists:sub_kegiatans,id',
                'kode_rekening_id' => 'required|exists:kode_rekenings,id',
                'sebesar' => 'required|numeric|min:0',
                'untuk_pengeluaran' => 'required|string|max:255',
                'dpp' => 'nullable|numeric|min:0',
                'nomor_st' => 'required|string',
                'tanggal_st' => 'required|date',
                'nomor_spd' => 'required|string',
                'tanggal_spd' => 'required|date',
                'bulan' => 'nullable|string|max:20',
                'kepala_dinas_id' => 'required|exists:kepala_dinas,id',
                'pptk_id' => 'required|exists:pptks,id',
                'bendahara_id' => 'required|exists:bendaharas,id',
                'penerima_id' => 'required|exists:pegawais,id',
            ]);

            // Ambil semua data yang akan diupdate
            $data = $request->all();
            $data['bidang_id'] = auth()->user()->bidang_id;
            $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);
            $data['bulan'] = $request->bulan ?: null;
            // Ambil kode rekening terkait
            $kodeRekening = KodeRekening::findOrFail($request->kode_rekening_id);
            $selisih = $rincianSppd->sebesar - $request->sebesar;

            // Mengelola perubahan anggaran
            if ($selisih > 0) {
                // Jika anggaran lama lebih besar, kembalikan selisih ke kode rekening
                $kodeRekening->anggaran += $selisih;
            } elseif ($selisih < 0) {
                // Jika anggaran baru lebih besar, cek apakah kode rekening mencukupi
                if ($kodeRekening->anggaran < abs($selisih)) {
                    return redirect()->back()->withErrors(['anggaran' => 'Anggaran pada Kode Rekening tidak mencukupi.'])->withInput();
                }
                // Jika cukup, kurangi kode rekening
                $kodeRekening->anggaran -= abs($selisih);
            }

            // Simpan perubahan anggaran pada kode rekening
            $kodeRekening->save();

            // Update rincian belanja
            $rincianSppd->update($data);

            // Commit transaksi jika semuanya berhasil
            DB::commit();
            return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $e) {
            // Rollback transaksi jika ada kesalahan
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }



    public function destroy($id)
    {
        $rincianSppd = RincianBelanjaSppd::findOrFail($id);

        $kodeRekening = KodeRekening::findOrFail($rincianSppd->kode_rekening_id);
        $kodeRekening->anggaran += $rincianSppd->sebesar;
        $kodeRekening->save();

        $rincianSppd->delete();

        return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil dihapus.');
    }

    private function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
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

        return trim($temp);
    }

    private function terbilangRupiah($angka)
    {
        return ucwords($this->terbilang($angka)) . " Rupiah";
    }

    public function exportDetailPdf($id)
    {
        $rincianSppd = RincianBelanjaSppd::with([
            'program',
            'kegiatan',
            'subKegiatan',
            'kodeRekening',
            'kepalaDinas',
            'pptk',
            'bendahara',
            'penerima',
            'bidang',
        ])->findOrFail($id);

        $pdf = Pdf::loadView('rincian_belanja_sppd.pdf_detail', compact('rincianSppd'))
            ->setPaper([0, 0, 612, 936]);

        return $pdf->stream("rincian-belanja-sppd-{$rincianSppd->id}.pdf");
    }
}
