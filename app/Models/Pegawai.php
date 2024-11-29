<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip', 'nama', 'pangkat', 'jabatan', 'nomor_rekening', 'nama_bank', 'bidang_id'
    ];

    // Relasi dengan Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}
