<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableScore extends Migration
{
    public function up()
    {
        Schema::create('score', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_users')->unsigned();
            $table->foreign('id_users')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->bigInteger('id_game')->unsigned();
            $table->foreign('id_game')
                ->references('id')
                ->on('game')
                ->onDelete('cascade');
            $table->integer('score_1');
            $table->integer('score_2');
            $table->integer('type_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('score');
    }
}