<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTeam extends Migration
{
    public function up()
    {
        Schema::create('team', function (Blueprint $table) {
            $table->id();
            $table->string('name_team');
            $table->string('city_team')->nullable();
            $table->string('path_image')->nullable();
            $table->integer('team_status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('team');
    }
}