<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;

class RincianBelanjaSppd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kode_rekening_id',
        'program_id',
        'kegiatan_id',
        'sub_kegiatan_id',
        'kepala_dinas_id',
        'pptk_id',
        'bendahara_id',
        'penerima_id',
        'bidang_id',
        'sebesar', // Kolom jumlah uang (bruto)
        'terbilang_rupiah',
        'untuk_pengeluaran',
        'nomor_st',
        'tanggal_st',
        'nomor_spd',
        'tanggal_spd',
        'bulan',
        'anggaran',
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
        return $this->belongsTo(Pptk::class, 'pptk_id');
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

        // Sebelum data dibuat, kurangi anggaran kode rekening
        static::creating(function ($model) {
            DB::transaction(function () use ($model) {
                $kodeRekening = KodeRekening::find($model->kode_rekening_id);

                if (!$kodeRekening) {
                    Log::error('Kode Rekening tidak ditemukan saat membuat Rincian Belanja SPPD.');
                    throw new \Exception('Kode Rekening tidak ditemukan.');
                }

                if ($kodeRekening->anggaran < $model->sebesar) {
                    throw new \Exception('Anggaran pada Kode Rekening tidak mencukupi.');
                }

                $kodeRekening->decrement('anggaran', $model->sebesar);
            });
        });

        // Sebelum data diperbarui, sesuaikan anggaran kode rekening
        static::updating(function ($model) {
            DB::transaction(function () use ($model) {
                $kodeRekening = KodeRekening::find($model->kode_rekening_id);

                if (!$kodeRekening) {
                    throw new \Exception('Kode Rekening tidak ditemukan.');
                }

                // Hitung selisih antara nilai lama dan yang baru
                $selisih = $model->getOriginal('sebesar') - $model->sebesar;

                if ($selisih > 0) {
                    // Jika nilai berkurang, tambahkan kembali ke kode rekening
                    $kodeRekening->increment('anggaran', abs($selisih));
                } elseif ($selisih < 0) {
                    // Jika bertambah, cek apakah cukup anggaran
                    if ($kodeRekening->anggaran < abs($selisih)) {
                        throw new \Exception('Anggaran tidak mencukupi untuk perubahan.');
                    }
                    $kodeRekening->decrement('anggaran', abs($selisih));
                }
            });
        });

        // Sebelum data dihapus (Soft Delete), kembalikan anggaran ke kode rekening
        static::deleting(function ($model) {
            DB::transaction(function () use ($model) {
                $kodeRekening = KodeRekening::find($model->kode_rekening_id);

                if (!$kodeRekening) {
                    throw new \Exception('Kode Rekening tidak ditemukan.');
                }

                $kodeRekening->increment('anggaran', $model->sebesar);
            });
        });

        // Jika dihapus secara permanen, tetap kembalikan anggaran
        static::forceDeleting(function ($model) {
            DB::transaction(function () use ($model) {
                $kodeRekening = KodeRekening::find($model->kode_rekening_id);

                if ($kodeRekening) {
                    $kodeRekening->increment('anggaran', $model->sebesar);
                }
            });
        });
    }

    public function getPbjtAttribute()
    {
        return $this->dpp * 0.1;
    }

    // Accessor untuk menghitung Netto



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
