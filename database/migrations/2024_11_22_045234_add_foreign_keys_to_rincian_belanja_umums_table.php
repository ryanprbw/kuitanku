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
        Schema::table('rincian_belanja_umums', function (Blueprint $table) {
            $table->foreign(['bidang_id'])->references(['id'])->on('bidangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['kegiatan_id'])->references(['id'])->on('kegiatans')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['program_id'])->references(['id'])->on('programs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_kegiatan_id'])->references(['id'])->on('sub_kegiatans')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['bendahara_id'], 'rincian_belanja_umum_bendahara_id_foreign')->references(['id'])->on('bendaharas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kegiatan_id'], 'rincian_belanja_umum_kegiatan_id_foreign')->references(['id'])->on('kegiatans')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kepala_dinas_id'], 'rincian_belanja_umum_kepala_dinas_id_foreign')->references(['id'])->on('kepala_dinas')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['kode_rekening_id'], 'rincian_belanja_umum_kode_rekening_id_foreign')->references(['id'])->on('kode_rekenings')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['penerima_id'], 'rincian_belanja_umum_penerima_id_foreign')->references(['id'])->on('pegawais')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['pptk_id'], 'rincian_belanja_umum_pptk_id_foreign')->references(['id'])->on('pptks')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['program_id'], 'rincian_belanja_umum_program_id_foreign')->references(['id'])->on('programs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['sub_kegiatan_id'], 'rincian_belanja_umum_sub_kegiatan_id_foreign')->references(['id'])->on('sub_kegiatans')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rincian_belanja_umums', function (Blueprint $table) {
            $table->dropForeign('rincian_belanja_umums_bidang_id_foreign');
            $table->dropForeign('rincian_belanja_umums_kegiatan_id_foreign');
            $table->dropForeign('rincian_belanja_umums_program_id_foreign');
            $table->dropForeign('rincian_belanja_umums_sub_kegiatan_id_foreign');
            $table->dropForeign('rincian_belanja_umum_bendahara_id_foreign');
            $table->dropForeign('rincian_belanja_umum_kegiatan_id_foreign');
            $table->dropForeign('rincian_belanja_umum_kepala_dinas_id_foreign');
            $table->dropForeign('rincian_belanja_umum_kode_rekening_id_foreign');
            $table->dropForeign('rincian_belanja_umum_penerima_id_foreign');
            $table->dropForeign('rincian_belanja_umum_pptk_id_foreign');
            $table->dropForeign('rincian_belanja_umum_program_id_foreign');
            $table->dropForeign('rincian_belanja_umum_sub_kegiatan_id_foreign');
        });
    }
};
