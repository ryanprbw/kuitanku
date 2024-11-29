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
        // Menambahkan kolom bulan, tipe data string bisa diubah sesuai kebutuhan (misalnya integer untuk nomor bulan)
        $table->string('bulan')->nullable()->after('netto');  // Menambahkan kolom bulan setelah kolom ppn
    });
}

public function down()
{
    Schema::table('rincian_belanja_umums', function (Blueprint $table) {
        $table->dropColumn('bulan');
    });
}

};
