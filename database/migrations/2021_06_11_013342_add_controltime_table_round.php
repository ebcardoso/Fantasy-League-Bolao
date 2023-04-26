<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddControltimeTableRound extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('round', function (Blueprint $table) {
            $table->dateTime('dtinitdiplay')->nullable();
            $table->dateTime('dtfinishdiplay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('round', function (Blueprint $table) {
            //
        });
    }
}
