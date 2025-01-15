<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rincian_belanja_umums', function (Blueprint $table) {
            $table->string('bulan')->nullable()->after('netto'); // Tambahkan kolom bulan
        });
    }

    public function down()
    {
        Schema::table('rincian_belanja_umums', function (Blueprint $table) {
            $table->dropColumn('bulan');
        });
    }
};
