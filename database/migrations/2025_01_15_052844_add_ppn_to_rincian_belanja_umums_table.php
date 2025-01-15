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
            $table->decimal('ppn', 15, 2)->nullable()->after('pbjt'); // Sesuaikan posisi kolom
        });
    }

    public function down()
    {
        Schema::table('rincian_belanja_umums', function (Blueprint $table) {
            $table->dropColumn('ppn');
        });
    }
};
