<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rincian_belanja_v2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('program_id')->index('rincian_belanja_v2_program_id_foreign');
            $table->unsignedBigInteger('kegiatan_id')->index('rincian_belanja_v2_kegiatan_id_foreign');
            $table->unsignedBigInteger('sub_kegiatan_id')->index('rincian_belanja_v2_sub_kegiatan_id_foreign');
            $table->unsignedBigInteger('kode_rekening_id')->index('rincian_belanja_v2_kode_rekening_id_foreign');
            $table->text('terbilang');
            $table->string('untuk_pengeluaran');
            $table->string('nomor_st');
            $table->date('tanggal_st');
            $table->string('nomor_spd');
            $table->date('tanggal_spd');
            $table->decimal('anggaran', 15);
            $table->unsignedBigInteger('kepala_dinas_id')->index('rincian_belanja_v2_kepala_dinas_id_foreign');
            $table->unsignedBigInteger('pptk_id')->index('rincian_belanja_v2_pptk_id_foreign');
            $table->unsignedBigInteger('bendahara_id')->index('rincian_belanja_v2_bendahara_id_foreign');
            $table->unsignedBigInteger('pegawai_id')->index('rincian_belanja_v2_pegawai_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_belanja_v2');
    }
};
