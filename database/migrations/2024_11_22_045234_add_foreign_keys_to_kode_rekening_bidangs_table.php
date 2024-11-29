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
        Schema::table('kode_rekening_bidangs', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kode_rekenings_id'])->references(['id'])->on('kode_rekenings')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_rekening_bidangs', function (Blueprint $table) {
            $table->dropForeign('kode_rekening_bidangs_bidang_id_foreign');
            $table->dropForeign('kode_rekening_bidangs_kode_rekenings_id_foreign');
        });
    }
};
