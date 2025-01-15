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
        Schema::create('programs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('skpd_id')->index('programs_skpd_id_foreign');
            $table->string('nama');
            $table->decimal('anggaran', 15);
            $table->timestamps();
            $table->unsignedBigInteger('bidang_id')->nullable()->index('programs_bidang_id_foreign');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
