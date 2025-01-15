<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('buku_pengeluaran_barang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_barang');
            $table->integer('mutasi_tambah')->nullable();
            $table->integer('mutasi_keluar')->nullable();
            $table->decimal('harga_satuan', 15, 2);
            $table->integer('jumlah');
            $table->decimal('nilai_saldo', 15, 2);
            $table->integer('sisa_saldo_barang');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_pengeluaran_barang');
    }
};
