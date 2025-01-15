<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBidangColumnFromPptksTable extends Migration
{
    public function up()
    {
        Schema::table('pptks', function (Blueprint $table) {
            $table->dropColumn('bidang');
        });
    }

    public function down()
    {
        Schema::table('pptks', function (Blueprint $table) {
            $table->string('bidang')->nullable();
        });
    }
}
