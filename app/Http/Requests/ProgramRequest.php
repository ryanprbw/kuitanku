<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    public function rules()
    {
        return [
            'nama' => 'required|string|max:255',
            'skpd_id' => 'required|exists:skpds,id',
            'bidang_id' => 'required|exists:bidangs,id',
            'anggaran_awal' => 'required|numeric|min:0',
            'anggaran' => 'required|numeric|min:0|lte:anggaran_awal', // Menambahkan validasi
        ];
    }


}
