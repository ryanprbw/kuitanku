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
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('no action')->onDelete('cascade');
            $table->foreign(['kegiatan_id'])->references(['id'])->on('kegiatans')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_kegiatans', function (Blueprint $table) {
            $table->dropForeign('sub_kegiatans_bidang_id_foreign');
            $table->dropForeign('sub_kegiatans_kegiatan_id_foreign');
        });
    }
};
