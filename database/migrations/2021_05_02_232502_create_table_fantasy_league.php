<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFantasyLeague extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fantasy_league', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_competition');
            $table->foreign('id_competition')                
                ->references('id')
                ->on('competition')
                ->onDelete('cascade');
            $table->string('name_fl');
            $table->string('status_fl');
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
        Schema::dropIfExists('fantasy_league');
    }
}
