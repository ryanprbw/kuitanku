<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'nama_kegiatan',
        'anggaran',
        'anggaran_awal',
        'bidang_id'
    ];

    protected $casts = [
        'anggaran' => 'float',
        'anggaran_awal' => 'float',
    ];

    // Relasi dengan Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    // Relasi dengan Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    // Relasi dengan SubKegiatan
    public function subKegiatan()
    {
        return $this->hasMany(SubKegiatan::class, 'kegiatan_id', 'id');
    }


    public function subKegiatans()
    {
        return $this->hasMany(SubKegiatan::class, 'kegiatan_id');
    }

    public function kodeRekenings()
    {
        return $this->hasMany(KodeRekening::class, 'kegiatan_id');
    }

    /**
     * Scope untuk mencari kegiatan berdasarkan program tertentu.
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Scope untuk mencari kegiatan berdasarkan bidang tertentu.
     */
    public function scopeByBidang($query, $bidangId)
    {
        return $query->where('bidang_id', $bidangId);
    }

    /**
     * Menghitung sisa anggaran kegiatan.
     */
    public function getSisaAnggaranAttribute()
    {
        return max(0, ($this->anggaran_awal ?? 0) - ($this->anggaran ?? 0));
    }

    /**
     * Mengurangi anggaran kegiatan.
     */
    public function kurangiAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah pengurangan anggaran harus lebih besar dari 0.');
        }

        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi.');
        }

        DB::transaction(function () use ($jumlah) {
            $this->decrement('anggaran', $jumlah);
            Log::info("Anggaran kegiatan dikurangi: {$jumlah}. Sisa anggaran: {$this->anggaran}");
        });
    }

    /**
     * Menambah anggaran kegiatan.
     */
    public function tambahAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah penambahan anggaran harus lebih besar dari 0.');
        }

        DB::transaction(function () use ($jumlah) {
            $this->increment('anggaran', $jumlah);
            Log::info("Anggaran kegiatan bertambah: {$jumlah}. Total anggaran: {$this->anggaran}");
        });
    }
}
