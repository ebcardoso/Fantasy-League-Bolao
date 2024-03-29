<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFantasyLeague extends Migration
{
    public function up()
    {
        Schema::create('fantasy_league', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_competition')->unsigned();
            $table->foreign('id_competition')                
                ->references('id')
                ->on('competition')
                ->onDelete('cascade');
            $table->string('name_fl');
            $table->string('status_fl');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fantasy_league');
    }
}