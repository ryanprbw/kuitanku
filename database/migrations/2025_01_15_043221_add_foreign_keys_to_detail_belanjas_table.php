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
        Schema::table('detail_belanjas', function (Blueprint $table) {
            $table->foreign(['sub_rincian_belanjas_id'])->references(['id'])->on('sub_rincian_belanjas')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_belanjas', function (Blueprint $table) {
            $table->dropForeign('detail_belanjas_sub_rincian_belanjas_id_foreign');
        });
    }
};
