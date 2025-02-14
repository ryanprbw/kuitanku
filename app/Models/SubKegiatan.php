<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class SubKegiatan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Field yang dapat diisi (mass assignment)
     */
    protected $fillable = [
        'kegiatan_id',         // Foreign key ke tabel kegiatan
        'nama_sub_kegiatan',   // Nama sub kegiatan
        'anggaran',            // Anggaran sub kegiatan
        'anggaran_awal',       // Anggaran awal sub kegiatan
        'bidang_id',           // Foreign key ke tabel bidang
    ];

    /**
     * Konversi tipe data untuk atribut tertentu
     */
    protected $casts = [
        'anggaran' => 'float',
        'anggaran_awal' => 'float',
    ];

    /**
     * Relasi dengan Kegiatan (SubKegiatan milik satu Kegiatan)
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id', 'id');
    }

    /**
     * Relasi dengan Bidang (SubKegiatan milik satu Bidang)
     */
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    /**
     * Relasi dengan KodeRekening (jika satu subkegiatan memiliki banyak kode rekening)
     */

    public function kodeRekenings()
    {
        return $this->hasMany(KodeRekening::class, 'sub_kegiatan_id');
    }


    /**
     * Relasi dengan RincianBelanjaUmum
     */
    public function rincianBelanjaUmum()
    {
        return $this->hasMany(RincianBelanjaUmum::class);
    }

    /**
     * Menghitung sisa anggaran (anggaran awal - anggaran yang telah digunakan)
     */
    public function getSisaAnggaranAttribute()
    {
        return $this->anggaran_awal - $this->anggaran;
    }

    /**
     * Mengurangi anggaran pada SubKegiatan.
     *
     * @param float $jumlah Jumlah anggaran yang akan dikurangi.
     * @throws \Exception Jika jumlah tidak valid atau anggaran tidak mencukupi.
     */
    public function kurangiAnggaran($jumlah)
    {
        if (!is_numeric($jumlah) || $jumlah <= 0) {
            Log::error("Pengurangan anggaran gagal: Jumlah tidak valid ({$jumlah}).");
            throw new \Exception('Jumlah pengurangan anggaran harus angka positif dan lebih besar dari 0.');
        }

        if ($this->anggaran < $jumlah) {
            Log::error("Pengurangan anggaran gagal: Anggaran tidak mencukupi. Anggaran saat ini: {$this->anggaran}, Pengurangan: {$jumlah}.");
            throw new \Exception('Anggaran tidak mencukupi.');
        }

        $this->anggaran -= $jumlah;
        $this->save();

        Log::info("Anggaran sub kegiatan '{$this->nama_sub_kegiatan}' berhasil dikurangi sebesar: {$jumlah}. Sisa anggaran: {$this->anggaran}");
    }

    /**
     * Menambah anggaran pada SubKegiatan.
     *
     * @param float $jumlah Jumlah anggaran yang akan ditambahkan.
     * @throws \Exception Jika jumlah tidak valid.
     */
    public function tambahAnggaran($jumlah)
    {
        if (!is_numeric($jumlah) || $jumlah <= 0) {
            Log::error("Penambahan anggaran gagal: Jumlah tidak valid ({$jumlah}).");
            throw new \Exception('Jumlah penambahan anggaran harus angka positif dan lebih besar dari 0.');
        }

        $this->anggaran += $jumlah;
        $this->save();

        Log::info("Anggaran sub kegiatan '{$this->nama_sub_kegiatan}' berhasil ditambah sebesar: {$jumlah}. Total anggaran: {$this->anggaran}");
    }

    /**
     * Scope untuk filter berdasarkan bidang tertentu.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $bidangId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByBidang($query, $bidangId)
    {
        return $query->where('bidang_id', $bidangId);
    }

}
