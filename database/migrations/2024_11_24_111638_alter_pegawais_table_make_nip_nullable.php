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
    Schema::table('pegawais', function (Blueprint $table) {
        $table->string('nip', 18)->nullable()->unique()->change();
    });
}

public function down()
{
    Schema::table('pegawais', function (Blueprint $table) {
        $table->string('nip', 18)->unique()->change(); // Sesuaikan rollback
    });
}

};
