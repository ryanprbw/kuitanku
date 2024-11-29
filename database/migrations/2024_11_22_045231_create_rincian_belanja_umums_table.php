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
        Schema::create('rincian_belanja_umums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kode_rekening_id')->index('rincian_belanja_umum_kode_rekening_id_foreign');
            $table->unsignedBigInteger('program_id')->index('rincian_belanja_umums_program_id_foreign');
            $table->unsignedBigInteger('kegiatan_id')->index('rincian_belanja_umums_kegiatan_id_foreign');
            $table->unsignedBigInteger('sub_kegiatan_id')->index('rincian_belanja_umums_sub_kegiatan_id_foreign');
            $table->unsignedBigInteger('kepala_dinas_id')->index('rincian_belanja_umum_kepala_dinas_id_foreign');
            $table->unsignedBigInteger('pptk_id')->index('rincian_belanja_umum_pptk_id_foreign');
            $table->unsignedBigInteger('bendahara_id')->index('rincian_belanja_umum_bendahara_id_foreign');
            $table->unsignedBigInteger('penerima_id')->index('rincian_belanja_umum_penerima_id_foreign');
            $table->unsignedBigInteger('bidang_id')->nullable()->index('rincian_belanja_umums_bidang_id_foreign');
            $table->decimal('anggaran', 15, 0);
            $table->string('terbilang_rupiah', 500)->nullable()->comment('Terbilang uang dalam teks');
            $table->string('untuk_pengeluaran', 500)->default('');
            $table->decimal('sebesar', 15, 0)->nullable()->comment('Jumlah uang yang diinput untuk perhitungan bruto');
            $table->decimal('bruto', 15, 0)->nullable()->comment('Bruto yang sama dengan sebesar');
            $table->decimal('dpp', 15, 0)->nullable()->comment('Dasar Pengenaan Pajak');
            $table->decimal('pph21', 15, 0)->nullable()->comment('PPh Pasal 21');
            $table->decimal('pph22', 15, 0)->nullable()->comment('PPh Pasal 22');
            $table->decimal('pph23', 15, 0)->nullable()->comment('PPh Pasal 23');
            $table->decimal('pbjt', 15, 0)->nullable()->comment('Pajak Barang dan Jasa (10% dari DPP)');
            $table->decimal('total_pajak', 15, 0)->nullable();
            $table->decimal('netto', 15, 0)->nullable()->comment('Nilai netto setelah pajak dikurangi dari pengeluaran');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_belanja_umums');
    }
};
