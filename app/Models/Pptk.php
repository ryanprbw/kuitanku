<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pptk extends Model
{
    use HasFactory;

    protected $fillable = [ 'nama', 'nip', 'bidang_id'];
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'bidang_id'); // Sesuaikan foreign key jika berbeda
    }
    

}