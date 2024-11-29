<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_skpd', 'anggaran'
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
        if ($this->anggaran < $jumlah) {
            throw new \Exception('Anggaran tidak mencukupi untuk mengurangi jumlah tersebut.');
        }

        $this->anggaran -= $jumlah;
        $this->save();
    }

    /**
     * Tambah anggaran SKPD.
     *
     * @param float $jumlah
     * @return void
     */
    public function tambahAnggaran($jumlah)
    {
        $this->anggaran += $jumlah;
        $this->save();
    }
}
