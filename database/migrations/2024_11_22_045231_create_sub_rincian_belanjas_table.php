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
        Schema::create('sub_rincian_belanjas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rincian_belanjas_id')->index('sub_rincian_belanjas_rincian_belanjas_id_foreign');
            $table->string('nama_sub_rincian');
            $table->decimal('anggaran', 15)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_rincian_belanjas');
    }
};
