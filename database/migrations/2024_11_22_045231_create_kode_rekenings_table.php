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
        Schema::create('kode_rekenings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_kode_rekening');
            $table->decimal('anggaran', 15)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('sub_kegiatan_id')->nullable()->index('kode_rekenings_sub_kegiatan_id_foreign');
            $table->unsignedBigInteger('bidang_id')->nullable()->index('kode_rekenings_bidang_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_rekenings');
    }
};
