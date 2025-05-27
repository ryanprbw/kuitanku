<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBarang extends Model
{
    use HasFactory;

    protected $table = 'detail_barang';
    protected $fillable = [
        'barang_id',
        'bidang_id',
        'tanggal',
        'mutasi_tambah',
        'mutasi_keluar',
        'harga_satuan',
        'jumlah',
        'nilai_saldo',
        'sisa_saldo_barang',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}
