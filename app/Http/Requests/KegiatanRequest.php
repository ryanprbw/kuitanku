<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     *
     * @return bool
     */
    public function authorize()
    {
        // Mengizinkan semua pengguna untuk mengakses form ini (bisa disesuaikan dengan kebutuhan)
        return true;
    }

    /**
     * Tentukan aturan validasi untuk permintaan ini.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'program_id' => 'required|exists:programs,id',  // Pastikan ID Program ada di tabel programs
            'bidang_id' => 'required|exists:bidangs,id',    // Pastikan ID Bidang ada di tabel bidangs
            'nama_kegiatan' => 'required|string|max:255',    // Nama kegiatan tidak boleh kosong dan maksimal 255 karakter
            'anggaran' => 'required|numeric|min:1',          // Anggaran harus angka dan lebih besar dari 0
            'anggaran_awal' => 'required|numeric|min:1',      // Anggaran awal harus angka dan lebih besar dari 0
        ];
    }

    /**
     * Pesan kesalahan yang akan ditampilkan jika validasi gagal.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'program_id.required' => 'Program harus dipilih.',
            'program_id.exists' => 'Program yang dipilih tidak valid.',
            'bidang_id.required' => 'Bidang harus dipilih.',
            'bidang_id.exists' => 'Bidang yang dipilih tidak valid.',
            'nama_kegiatan.required' => 'Nama kegiatan harus diisi.',
            'nama_kegiatan.string' => 'Nama kegiatan harus berupa teks.',
            'nama_kegiatan.max' => 'Nama kegiatan tidak boleh lebih dari 255 karakter.',
            'anggaran.required' => 'Anggaran harus diisi.',
            'anggaran.numeric' => 'Anggaran harus berupa angka.',
            'anggaran.min' => 'Anggaran minimal adalah 1.',
            'anggaran_awal.required' => 'Anggaran awal harus diisi.',
            'anggaran_awal.numeric' => 'Anggaran awal harus berupa angka.',
            'anggaran_awal.min' => 'Anggaran awal minimal adalah 1.',
        ];
    }
}
