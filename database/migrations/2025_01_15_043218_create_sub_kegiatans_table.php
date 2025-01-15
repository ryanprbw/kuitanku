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
        Schema::create('sub_kegiatans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bidang_id')->nullable()->index('sub_kegiatans_bidang_id_foreign');
            $table->unsignedBigInteger('kegiatan_id')->index('sub_kegiatans_kegiatans_id_foreign');
            $table->string('nama_sub_kegiatan');
            $table->decimal('anggaran', 15)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kegiatans');
    }
};
