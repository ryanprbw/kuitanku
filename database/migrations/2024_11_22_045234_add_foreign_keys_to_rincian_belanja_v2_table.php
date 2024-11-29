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
        Schema::table('rincian_belanja_v2', function (Blueprint $table) {
            $table->foreign(['bendahara_id'])->references(['id'])->on('bendaharas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kegiatan_id'])->references(['id'])->on('kegiatans')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kepala_dinas_id'])->references(['id'])->on('kepala_dinas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kode_rekening_id'])->references(['id'])->on('kode_rekenings')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pegawai_id'])->references(['id'])->on('pegawais')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pptk_id'])->references(['id'])->on('pptks')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['program_id'])->references(['id'])->on('programs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_kegiatan_id'])->references(['id'])->on('sub_kegiatans')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_belanja_v2', function (Blueprint $table) {
            $table->dropForeign('rincian_belanja_v2_bendahara_id_foreign');
            $table->dropForeign('rincian_belanja_v2_kegiatan_id_foreign');
            $table->dropForeign('rincian_belanja_v2_kepala_dinas_id_foreign');
            $table->dropForeign('rincian_belanja_v2_kode_rekening_id_foreign');
            $table->dropForeign('rincian_belanja_v2_pegawai_id_foreign');
            $table->dropForeign('rincian_belanja_v2_pptk_id_foreign');
            $table->dropForeign('rincian_belanja_v2_program_id_foreign');
            $table->dropForeign('rincian_belanja_v2_sub_kegiatan_id_foreign');
        });
    }
};
