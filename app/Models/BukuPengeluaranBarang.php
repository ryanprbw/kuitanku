<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuPengeluaranBarang extends Model
{
    use HasFactory;

    protected $table = 'buku_pengeluaran_barang';

    protected $fillable = [
        'tanggal',
        'nama_barang',
        'mutasi_tambah',
        'mutasi_keluar',
        'harga_satuan',
        'jumlah',
        'nilai_saldo',
        'sisa_saldo_barang',
        'keterangan',
    ];
}
