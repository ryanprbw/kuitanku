<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['nama_barang', 'harga_satuan', 'jumlah', 'nilai_saldo'];

    public function detailBarang()
    {
        return $this->hasMany(DetailBarang::class, 'barang_id');
    }
}
