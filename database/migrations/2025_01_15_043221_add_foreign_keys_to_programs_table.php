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
        Schema::table('programs', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('no action')->onDelete('set null');
            $table->foreign(['skpd_id'])->references(['id'])->on('skpds')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropForeign('programs_bidang_id_foreign');
            $table->dropForeign('programs_skpd_id_foreign');
        });
    }
};
