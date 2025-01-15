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
        Schema::create('rincian_belanja_sppds', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('kode_rekening_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('kegiatan_id');
            $table->unsignedBigInteger('sub_kegiatan_id');
            $table->unsignedBigInteger('kepala_dinas_id');
            $table->unsignedBigInteger('pptk_id');
            $table->unsignedBigInteger('bendahara_id');
            $table->unsignedBigInteger('penerima_id');
            $table->unsignedBigInteger('bidang_id');
            $table->decimal('sebesar', 15, 2)->default(0); // Jumlah uang (bruto)
            $table->string('terbilang_rupiah')->nullable(); // Terbilang
            $table->text('untuk_pengeluaran')->nullable();
            $table->string('nomor_st')->nullable();
            $table->date('tanggal_st')->nullable();
            $table->string('nomor_spd')->nullable();
            $table->date('tanggal_spd')->nullable();
            $table->string('bulan')->nullable();
            $table->decimal('anggaran', 15, 2)->default(0); // Anggaran
            $table->softDeletes(); // Soft delete
            $table->timestamps(); // Created at & Updated at

            // Foreign key constraints
            $table->foreign('kode_rekening_id')->references('id')->on('kode_rekenings')->onDelete('restrict');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('restrict');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->onDelete('restrict');
            $table->foreign('sub_kegiatan_id')->references('id')->on('sub_kegiatans')->onDelete('restrict');
            $table->foreign('kepala_dinas_id')->references('id')->on('kepala_dinas')->onDelete('restrict');
            $table->foreign('pptk_id')->references('id')->on('pptks')->onDelete('restrict');
            $table->foreign('bendahara_id')->references('id')->on('bendaharas')->onDelete('restrict');
            $table->foreign('penerima_id')->references('id')->on('pegawais')->onDelete('restrict');
            $table->foreign('bidang_id')->references('id')->on('bidangs')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_belanja_sppds');
    }
};
