<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bendahara extends Model
{
    use HasFactory;

    protected $table = 'bendaharas'; // Nama tabel yang benar
    protected $fillable = ['nama', 'nip'];
}
