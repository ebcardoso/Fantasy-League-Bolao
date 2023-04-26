<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableGame extends Migration
{
    public function up()
    {
        Schema::create('game', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_round')->unsigned();
            $table->foreign('id_round')
                ->references('id')
                ->on('round')
                ->onDelete('cascade');
            $table->bigInteger('id_team1')->unsigned(); //clube mandante
            $table->bigInteger('id_team2')->unsigned(); //clube visitante
            $table->integer('score1')->nullable();
            $table->integer('score2')->nullable();
            $table->integer('status_game')->nullable(); //1 - Não Processada | 2 - Processada
            $table->dateTime('game_ko')->nullable(); //kick-off time
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('game');
    }
}
