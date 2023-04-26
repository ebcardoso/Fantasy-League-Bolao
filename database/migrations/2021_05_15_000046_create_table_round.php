<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRound extends Migration
{
    public function up()
    {
        Schema::create('round', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_competition')->unsigned();
            $table->foreign('id_competition')                
                ->references('id')
                ->on('competition')
                ->onDelete('cascade');
            $table->string('name_round');
            $table->string('status_round'); //1-Futuro | 2-Disponível | 3-Em Andamento | 4-Fechada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('round');
    }
}