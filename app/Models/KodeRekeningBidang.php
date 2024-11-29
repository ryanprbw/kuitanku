<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeRekeningBidang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_rekenings_id',
        'bidangs_id',
        'anggaran',
    ];

    // Relasi dengan KodeRekening
    public function kodeRekening()
    {
        return $this->belongsTo(KodeRekening::class, 'kode_rekenings_id');
    }

    // Relasi ke tabel Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidangs_id');
    }

    // Mengurangi anggaran pada Kode Rekening Bidang
    public function kurangiAnggaran($jumlah)
    {
        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi.');
        }
        $this->anggaran -= $jumlah;
        $this->save();
    }
}
