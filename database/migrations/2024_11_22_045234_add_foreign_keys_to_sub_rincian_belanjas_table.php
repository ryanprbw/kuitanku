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
        Schema::table('sub_rincian_belanjas', function (Blueprint $table) {
            $table->foreign(['rincian_belanjas_id'])->references(['id'])->on('kode_rekenings')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_rincian_belanjas', function (Blueprint $table) {
            $table->dropForeign('sub_rincian_belanjas_rincian_belanjas_id_foreign');
        });
    }
};
