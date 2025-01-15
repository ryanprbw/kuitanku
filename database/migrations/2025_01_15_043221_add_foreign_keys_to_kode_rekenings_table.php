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
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['sub_kegiatan_id'])->references(['id'])->on('sub_kegiatans')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->dropForeign('kode_rekenings_bidang_id_foreign');
            $table->dropForeign('kode_rekenings_sub_kegiatan_id_foreign');
        });
    }
};
