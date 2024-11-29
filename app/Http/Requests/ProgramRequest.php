<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRequest extends FormRequest
{
    public function rules()
    {
        return [
            'skpd_id' => 'required|exists:skpds,id',
            'nama' => 'required|string|max:255',
            'anggaran' => 'required|numeric|min:1',
            'bidang_id' => 'required|exists:bidangs,id',
        ];
    }
}
