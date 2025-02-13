<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class KodeRekening extends Model
{
    use HasFactory, SoftDeletes;

    // Kolom yang dapat diisi secara massal
    protected $fillable = [
        'sub_kegiatan_id',  // Foreign key ke tabel sub_kegiatans
        'bidang_id',        // Foreign key ke tabel bidangs
        'nama_kode_rekening', // Nama kode rekening
        'anggaran_awal',         // Anggaran
        'anggaran',         // Anggaran
    ];

    // Konversi tipe data
    protected $casts = [
        'anggaran' => 'float', // Pastikan anggaran selalu bertipe float
    ];

    /**
     * Relasi dengan SubKegiatan (many-to-one).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subKegiatan()
    {
        return $this->belongsTo(SubKegiatan::class, 'sub_kegiatan_id', 'id');
    }
    public function rincianBelanjaUmum()
    {
        return $this->hasMany(RincianBelanjaUmum::class, 'kode_rekening_id', 'id');
    }
    public function rincianBelanjaSppd()
    {
        return $this->hasMany(RincianBelanjaSppd::class, 'kode_rekening_id', 'id');
    }

    /**
     * Relasi dengan Bidang (many-to-one).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }

    /**
     * Mengurangi anggaran pada Kode Rekening.
     *
     * @param float $jumlah Jumlah yang akan dikurangi dari anggaran.
     * @throws \Exception Jika jumlah tidak valid atau anggaran tidak mencukupi.
     * @return void
     */
    public function kurangiAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            Log::error("Pengurangan anggaran gagal: Jumlah tidak valid ({$jumlah}).");
            throw new \Exception('Jumlah pengurangan anggaran harus lebih besar dari 0.');
        }

        if ($this->anggaran < $jumlah) {
            Log::error("Pengurangan anggaran gagal: Anggaran tidak mencukupi. Sisa anggaran: {$this->anggaran}, Jumlah: {$jumlah}.");
            throw new \Exception('Anggaran tidak mencukupi.');
        }

        $this->anggaran -= $jumlah;
        $this->save();

        Log::info("Anggaran kode rekening dikurangi: {$jumlah}. Sisa anggaran: {$this->anggaran}");
    }

    /**
     * Mengembalikan anggaran kode rekening ke jumlah awal.
     *
     * @param float $jumlah Jumlah yang akan ditambahkan kembali ke anggaran.
     * @throws \Exception Jika jumlah tidak valid.
     * @return void
     */
    public function tambahAnggaran($jumlah)
    {
        if ($jumlah <= 0) {
            throw new \Exception('Jumlah penambahan anggaran harus lebih besar dari 0.');
        }

        $this->anggaran += $jumlah;
        $this->save();

        Log::info("Anggaran kode rekening ditambahkan: {$jumlah}. Total anggaran: {$this->anggaran}");
    }
}
