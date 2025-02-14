<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Skpd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_skpd',
        'anggaran',
        'anggaran_awal'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'anggaran' => 'float',
        'anggaran_awal' => 'float',
    ];

    /**
     * Kurangi anggaran SKPD.
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
     * Tambah anggaran SKPD.
     *
     * @param float $jumlah
     * @return void
     * @throws \Exception
     */
    public function tambahAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah anggaran yang ditambahkan harus lebih dari nol.');
        }

        DB::transaction(function () use ($jumlah) {
            $this->updateQuietly([
                'anggaran' => $this->anggaran + $jumlah
            ]);
        });
    }

    /**
     * Relasi ke Program
     */
    public function programs()
    {
        return $this->hasMany(Program::class, 'skpd_id', 'id');
    }
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'skpd_id')->onDelete('cascade');
    }
}
