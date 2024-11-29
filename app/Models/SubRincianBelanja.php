<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRincianBelanja extends Model
{
    use HasFactory;

    protected $fillable = ['rincian_belanja_id', 'nama', 'anggaran'];

    public function rincianBelanja()
    {
        return $this->belongsTo(RincianBelanja::class);
    }

    public function detailBelanja()
    {
        return $this->hasMany(DetailBelanja::class);
    }
}
