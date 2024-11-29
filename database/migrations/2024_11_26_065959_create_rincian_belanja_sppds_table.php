<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRincianBelanjaSppdsTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rincian_belanja_sppds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kode_rekening_id')->constrained()->onDelete('cascade');
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_kegiatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kepala_dinas_id')->constrained()->onDelete('cascade');
            $table->foreignId('pptk_id')->constrained()->onDelete('cascade');
            $table->foreignId('bendahara_id')->constrained()->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
            $table->foreignId('bidang_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nomor_st');
            $table->date('tanggal_st')->nullable();
            $table->string('nomor_spd');
            $table->date('tanggal_spd')->nullable();
            $table->decimal('anggaran', 15, 0);
            $table->string('terbilang_rupiah', 500)->nullable()->default(null)->comment('Terbilang uang dalam teks');
            $table->string('untuk_pengeluaran', 500)->default('')->comment('Keterangan pengeluaran');
            $table->decimal('sebesar', 15, 0)->nullable()->default(null)->comment('Jumlah uang yang diinput untuk perhitungan bruto');
            $table->string('bulan', 255)->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes(); // Untuk mendukung soft delete
        });
    }

    /**
     * Balikkan migrasi (drop tabel).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rincian_belanja_sppds');
    }
}
