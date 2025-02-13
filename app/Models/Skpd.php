<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_skpd',
        'anggaran',
        'anggaran_awal'
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

    public function tambahAnggaran($jumlah)
    {
        if ($jumlah < 0) {
            throw new \Exception('Jumlah anggaran yang ditambahkan tidak boleh negatif.');
        }
        $this->anggaran += $jumlah;
        $this->save();
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'skpd_id', 'id');
    }
}
