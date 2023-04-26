<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFlJoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fl_join', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_fantasy_league')->unsigned();
            $table->foreign('id_fantasy_league')
                ->references('id')
                ->on('fantasy_league')
                ->onDelete('cascade');
            $table->bigInteger('id_users')->unsigned();
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('is_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fl_join');
    }
}
