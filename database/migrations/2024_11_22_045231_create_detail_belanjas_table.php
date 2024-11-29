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
        Schema::create('detail_belanjas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_rincian_belanjas_id')->index('detail_belanjas_sub_rincian_belanjas_id_foreign');
            $table->string('nama_detail');
            $table->decimal('jumlah', 15)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_belanjas');
    }
};
