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
        // $kepala_dinas = KepalaDinas::all();
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

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['bidang_id'] = auth()->user()->bidang_id;
            $data['terbilang_rupiah'] = $this->terbilangRupiah($request->sebesar);
            $data['bulan'] = $request->bulan ?: null;

            // Cek apakah anggaran mencukupi (tanpa memotong di sini)
            $kodeRekening = KodeRekening::where('id', $request->kode_rekening_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($kodeRekening->anggaran < $request->sebesar) {
                DB::rollBack();
                return redirect()->back()->withErrors(['anggaran' => 'Anggaran tidak mencukupi.'])->withInput();
            }

            // Simpan data (pemotongan anggaran dilakukan otomatis di model)
            RincianBelanjaSppd::create($data);

            DB::commit();
            return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
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

            $kodeRekeningLama = KodeRekening::where('id', $rincianSppd->kode_rekening_id)->lockForUpdate()->firstOrFail();
            $kodeRekeningBaru = KodeRekening::where('id', $request->kode_rekening_id)->lockForUpdate()->firstOrFail();

            // Jika rekening tetap, hanya cek selisih
            if ($kodeRekeningLama->id === $kodeRekeningBaru->id) {
                $selisih = $rincianSppd->sebesar - $request->sebesar;

                if ($selisih < 0 && $kodeRekeningBaru->anggaran < abs($selisih)) {
                    return back()->withErrors(['anggaran' => 'Anggaran tidak mencukupi.'])->withInput();
                }

                // Update anggaran
                $kodeRekeningBaru->anggaran += $selisih;
                $kodeRekeningBaru->save();

            } else {
                // Kembalikan anggaran ke rekening lama
                $kodeRekeningLama->anggaran += $rincianSppd->sebesar;
                $kodeRekeningLama->save();

                // Kurangi dari rekening baru
                if ($kodeRekeningBaru->anggaran < $request->sebesar) {
                    return back()->withErrors(['anggaran' => 'Anggaran tidak mencukupi di rekening baru.'])->withInput();
                }

                $kodeRekeningBaru->anggaran -= $request->sebesar;
                $kodeRekeningBaru->save();
            }

            // Simpan data SPPD
            $rincianSppd->update($data);

            DB::commit();
            return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }





    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $rincianSppd = RincianBelanjaSppd::findOrFail($id);

            // Ambil kode rekening dan kembalikan anggarannya
            $kodeRekening = KodeRekening::where('id', $rincianSppd->kode_rekening_id)
                ->lockForUpdate()
                ->firstOrFail();

            $kodeRekening->anggaran += $rincianSppd->sebesar;
            $kodeRekening->save();

            // Hapus data SPPD
            $rincianSppd->delete();

            DB::commit();
            return redirect()->route('rincian_belanja_sppd.index')->with('success', 'Data berhasil dihapus dan anggaran dikembalikan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menghapus data: ' . $e->getMessage()]);
        }
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
