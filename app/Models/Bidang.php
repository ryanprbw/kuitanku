<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $fillable = ['nama_bidang'];

    // Relasi dengan Pegawai
    public function pegawais()
    {
        return $this->hasMany(Pegawai::class);
    }
    
    public function kodeRekeningBidangs()
    {
        return $this->hasMany(KodeRekeningBidang::class, 'bidang_id'); 
    }
    
    public function programs()
    {
        return $this->hasMany(Program::class, 'bidang_id');
    }
    public function kodeRekenings()
{
    return $this->hasMany(KodeRekening::class, 'bidang_id');
}
public function subKegiatans()
{
    return $this->hasMany(SubKegiatan::class, 'bidang_id');
}

public function pptks()
{
    return $this->hasMany(PPTK::class, 'bidang_id');
}


}
