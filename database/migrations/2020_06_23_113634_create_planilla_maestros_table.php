<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillaMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_maestros', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('no_planilla')->default('1');
            $table->string('titulo');
            $table->string('anio');
            $table->unsignedInteger('contador_id');
            $table->decimal('total', 9,2);
            $table->unsignedInteger('estado_planilla_id')->default('1');
            $table->date('fecha_planilla');
            $table->timestamps();
            //foreign
            $table->foreign('contador_id')->references('id')->on('users');
            $table->foreign('estado_planilla_id')->references('id')->on('estado_planillas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planilla_maestros');
    }
}
