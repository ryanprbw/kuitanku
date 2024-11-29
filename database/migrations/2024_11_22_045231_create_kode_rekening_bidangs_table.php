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
        Schema::create('kode_rekening_bidangs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kode_rekenings_id')->index('kode_rekening_bidangs_kode_rekenings_id_foreign');
            $table->unsignedBigInteger('bidang_id')->index('kode_rekening_bidangs_bidang_id_foreign');
            $table->decimal('anggaran', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_rekening_bidangs');
    }
};
