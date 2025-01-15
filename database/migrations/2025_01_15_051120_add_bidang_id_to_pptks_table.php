<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBidangIdToPptksTable extends Migration
{
    public function up()
    {
        Schema::table('pptks', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_id')->nullable()->after('nip');
            $table->foreign('bidang_id')->references('id')->on('bidangs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pptks', function (Blueprint $table) {
            $table->dropForeign(['bidang_id']);
            $table->dropColumn('bidang_id');
        });
    }
};
