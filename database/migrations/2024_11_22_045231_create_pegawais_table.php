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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nip', 18)->nullable();
            $table->string('nama');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('nomor_rekening');
            $table->string('nama_bank');
            $table->unsignedBigInteger('bidang_id')->index('pegawais_bidang_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};
