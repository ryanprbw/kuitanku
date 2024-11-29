<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SubKegiatan extends Model
{
    use HasFactory;

    // Field yang dapat diisi
    protected $fillable = [
        'kegiatan_id',        // Foreign key ke tabel kegiatan
        'nama_sub_kegiatan',  // Nama sub kegiatan
        'anggaran',           // Anggaran sub kegiatan
        'bidang_id',           // Anggaran sub kegiatan
    ];

    // Konversi properti anggaran menjadi float
    protected $casts = [
        'anggaran' => 'float',
    ];

    /**
     * Relasi dengan Kegiatan.
     *
     * Sub Kegiatan terkait dengan satu Kegiatan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    /**
     * Relasi dengan KodeRekening.
     *
     * Sub Kegiatan terhubung ke satu Kode Rekening.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kodeRekening()
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekening_id');
    }
    public function kodeRekenings()
    {
        return $this->hasMany(KodeRekening::class, 'sub_kegiatan_id');
    }
    public function bidang()
{
    return $this->belongsTo(Bidang::class, 'bidang_id');
}

    
    
    /**
     * Mengurangi anggaran pada SubKegiatan.
     *
     * @param float $jumlah Jumlah anggaran yang akan dikurangi.
     * @throws \Exception Jika jumlah tidak valid atau anggaran tidak mencukupi.
     * @return void
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
    public function scopeByBidang($query, $bidangId)
{
    return $query->where('bidang_id', $bidangId);
}
}
