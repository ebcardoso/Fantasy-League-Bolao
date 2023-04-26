<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompetition extends Migration
{
    public function up()
    {
        Schema::create('competition', function (Blueprint $table) {
            $table->id();
            $table->string('name_comp');
            $table->string('path_image')->nullable();
            $table->integer('type_comp'); //1-Estadual | 2-Regional | 3-Nacional | 4-Times-Internacional | 5-Seleções
            $table->integer('status_comp'); //1-Em Andamento | 2-Finalizado | 3-Futuro
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competition');
    }
}