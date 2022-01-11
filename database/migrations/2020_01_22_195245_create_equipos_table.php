<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('equipo');
            $table->longText('descripcion')->nullable();
            $table->unsignedInteger('estado_id')->default('1');
            $table->unsignedInteger('ubicacion_id')->default('1');
            //foreign
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones_equipo');
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
        Schema::dropIfExists('equipos');
    }
}
