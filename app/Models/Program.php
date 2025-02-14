<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    protected $casts = [
        'anggaran' => 'float',
        'anggaran_awal' => 'float',
    ];

    // Relasi dengan tabel Kegiatan (hapus duplikasi)
    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class, 'program_id', 'id');
    }

    // Relasi ke SKPD
    public function skpd()
    {
        return $this->belongsTo(Skpd::class, 'skpd_id');
    }

    // Relasi ke Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    /**
     * Mengurangi anggaran pada Program.
     *
     * @param float $jumlah
     * @return void
     * @throws \Exception
     */
    public function kurangiAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah yang dikurangi harus lebih dari nol.');
        }

        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi untuk mengurangi jumlah tersebut.');
        }

        DB::transaction(function () use ($jumlah) {
            $this->updateQuietly([
                'anggaran' => $this->anggaran - $jumlah
            ]);
        });
    }

    /**
     * Menambah anggaran pada Program.
     *
     * @param float $jumlah
     * @return void
     * @throws \Exception
     */
    public function tambahAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah yang ditambahkan harus lebih dari nol.');
        }

        DB::transaction(function () use ($jumlah) {
            $this->updateQuietly([
                'anggaran' => $this->anggaran + $jumlah
            ]);
        });
    }
}
