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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['program_id'], 'kegiatans_programs_id_foreign')->references(['id'])->on('programs')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign('kegiatans_bidang_id_foreign');
            $table->dropForeign('kegiatans_programs_id_foreign');
        });
    }
};
