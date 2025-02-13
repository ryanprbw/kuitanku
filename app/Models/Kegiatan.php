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
    ];

    /**
     * Relasi dengan Program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

    /**
     * Relasi dengan Bidang.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    /**
     * Relasi dengan SubKegiatan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subKegiatan()
    {
        return $this->hasMany(SubKegiatan::class, 'kegiatan_id', 'id');
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
     *
     * @return float
     */
    public function getSisaAnggaranAttribute()
    {
        return max(0, $this->anggaran_awal - $this->anggaran);
    }

    /**
     * Mengurangi anggaran kegiatan.
     *
     * @param float $jumlah
     * @throws \Exception Jika jumlah tidak valid atau anggaran tidak mencukupi.
     */
    public function kurangiAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah pengurangan anggaran harus lebih besar dari 0.');
        }

        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi.');
        }

        $this->decrement('anggaran', $jumlah);
        Log::info("Anggaran kegiatan dikurangi: {$jumlah}. Sisa anggaran: {$this->anggaran}");
    }

    /**
     * Menghitung jumlah sub-kegiatan dalam kegiatan ini.
     *
     * @return int
     */
    public function jumlahSubKegiatan()
    {
        return $this->subKegiatan()->count();
    }

    /**
     * Menghitung total anggaran dari semua sub-kegiatan.
     *
     * @return float
     */
    public function totalAnggaranSubKegiatan()
    {
        return $this->subKegiatan()->sum('anggaran') ?? 0;
    }
}
