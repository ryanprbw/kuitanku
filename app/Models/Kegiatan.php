<?php

namespace App\Models;

use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
    public function getSisaAnggaranAttribute()
    {
        return $this->anggaran_awal - $this->anggaran;
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
     * Scope untuk kegiatan berdasarkan program tertentu.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $programId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByProgram($query, $programId)
    {
        return $query->where('program_id', $programId);
    }

    /**
     * Mengurangi anggaran pada Kegiatan.
     *
     * @param float $jumlah Jumlah anggaran yang akan dikurangi.
     * @throws \Exception Jika jumlah tidak valid atau anggaran tidak mencukupi.
     * @return void
     */

    public function kurangiAnggaran($jumlah)
    {
        DB::transaction(function () use ($jumlah) {
            if ($jumlah <= 0) {
                throw new \Exception('Jumlah pengurangan anggaran harus lebih besar dari 0.');
            }

            if ($this->anggaran < $jumlah) {
                throw new \Exception('Anggaran tidak mencukupi.');
            }

            $this->anggaran -= $jumlah;
            $this->save();

            Log::info("Anggaran kegiatan dikurangi: {$jumlah}. Sisa anggaran: {$this->anggaran}");
        });
    }

    /**
     * Menghitung jumlah SubKegiatan.
     *
     * @return int Jumlah subkegiatan.
     */
    public function jumlahSubKegiatan()
    {
        return $this->subKegiatan()->count();
    }

    /**
     * Menghitung total anggaran dari SubKegiatan.
     *
     * @return float Total anggaran semua subkegiatan.
     */
    public function totalAnggaranSubKegiatan()
    {
        return $this->subKegiatan()->sum('anggaran');
    }
    public function scopeByBidang($query, $bidangId)
    {
        return $query->where('bidang_id', $bidangId);
    }

}
