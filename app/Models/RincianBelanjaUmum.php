<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RincianBelanjaUmum extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'bidang_id',
        'kegiatan_id',
        'sub_kegiatan_id',
        'kode_rekening_id',
        'sebesar', // Kolom jumlah uang (bruto)
        'terbilang_rupiah',
        'untuk_pengeluaran',
        'bruto',
        'dpp',
        'pph21',
        'pph22',
        'pph23',
        'ppn',
        'pbjt',
        'total_pajak',
        'netto',
        'bulan',
        'anggaran',
        'kepala_dinas_id',
        'pptk_id',
        'bendahara_id',
        'penerima_id',
    ];


    // Relasi dengan KodeRekening
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id');
    }
    public function kodeRekening()
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }
    public function kepalaDinas()
    {
        return $this->belongsTo(KepalaDinas::class, 'kepala_dinas_id');
    }
    public function pptk()
    {
        return $this->belongsTo(PPTK::class, 'pptk_id');
    }
    public function bendahara()
    {
        return $this->belongsTo(Bendahara::class, 'bendahara_id');
    }

    // Relasi dengan Penerima
    public function penerima()
    {
        return $this->belongsTo(Pegawai::class, 'penerima_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }






    // Relasi dengan KepalaDinas

    // Relasi dengan PPTK

    // Relasi dengan Bendahara

    /**
     * Event Hook: Mengurangi anggaran pada kode_rekening sebelum membuat data baru.
     *
     * @return void
     * @throws \Exception
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $kodeRekening = $model->kodeRekening;

            if (!$kodeRekening) {
                throw new \Exception('Kode Rekening tidak ditemukan.');
            }

            if ($kodeRekening->anggaran < $model->pengeluaran) {
                throw new \Exception('Anggaran pada Kode Rekening tidak mencukupi.');
            }

            $kodeRekening->anggaran -= $model->pengeluaran;
            $kodeRekening->save();
        });

        static::updating(function ($model) {
            $kodeRekening = $model->kodeRekening;

            if (!$kodeRekening) {
                throw new \Exception('Kode Rekening tidak ditemukan.');
            }

            // Hitung selisih pengeluaran
            $selisih = $model->getOriginal('pengeluaran') - $model->pengeluaran;

            if ($selisih > 0) {
                // Kembalikan anggaran jika pengeluaran berkurang
                $kodeRekening->anggaran += abs($selisih);
            } elseif ($kodeRekening->anggaran < abs($selisih)) {
                // Cek apakah anggaran mencukupi untuk pengeluaran tambahan
                throw new \Exception('Anggaran pada Kode Rekening tidak mencukupi untuk perubahan.');
            } else {
                // Kurangi anggaran jika pengeluaran bertambah
                $kodeRekening->anggaran -= abs($selisih);
            }

            $kodeRekening->save();
        });

        static::deleting(function ($model) {
            $kodeRekening = $model->kodeRekening;

            if (!$kodeRekening) {
                throw new \Exception('Kode Rekening tidak ditemukan.');
            }

            // Kembalikan anggaran jika rincian belanja dihapus
            $kodeRekening->anggaran += $model->pengeluaran;
            $kodeRekening->save();
        });
    }
    public function getPbjtAttribute()
    {
        return $this->dpp * 0.1;
    }

    // Accessor untuk menghitung Netto
    public function getNettoAttribute()
    {
        $totalPajak = ($this->pph21 ?? 0) + ($this->pph22 ?? 0) + ($this->pph23 ?? 0) + ($this->ppn ?? 0);
        return $this->bruto - $totalPajak;
    }


    // Accessor untuk Terbilang
    public function getTerbilangRupiahAttribute()
    {
        return ucwords($this->terbilang($this->sebesar)) . ' Rupiah';
    }

    // Fungsi untuk konversi angka ke terbilang
    private function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp = "";
        if ($angka < 12) {
            $temp = " " . $huruf[$angka];
        } elseif ($angka < 20) {
            $temp = $this->terbilang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            $temp = $this->terbilang($angka / 10) . " Puluh" . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $temp = " Seratus" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $temp = $this->terbilang($angka / 100) . " Ratus" . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $temp = " Seribu" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $temp = $this->terbilang($angka / 1000) . " Ribu" . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $temp = $this->terbilang($angka / 1000000) . " Juta" . $this->terbilang($angka % 1000000);
        }
        return trim($temp);
    }
}
