<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'satuan', 'harga_satuan', 'jumlah', 'nilai_saldo', 'keterangan', 'bidang_id'];

    public function detailBarang()
    {
        return $this->hasMany(DetailBarang::class, 'barang_id');
    }
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id');
    }
}
