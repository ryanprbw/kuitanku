<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'skpd_id',
        'nama',
        'anggaran',
        'anggaran_awal',
        'bidang_id'
    ];

    // Relasi dengan tabel Kegiatan
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'program_id', 'id');
    }
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'program_id', 'id');
    }
    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Mengurangi anggaran pada Program
    public function kurangiAnggaran($jumlah)
    {
        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi untuk mengurangi jumlah tersebut.');
        }

        $this->anggaran -= $jumlah;
        $this->save();
    }

    /**
     * Tambah anggaran SKPD.
     *
     * @param float $jumlah
     * @return void
     */
    public function tambahAnggaran($jumlah)
    {
        $this->anggaran += $jumlah;
        $this->save();
    }

}


