<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroEnvioEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_envio_equipos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_envio');
            $table->string('anio');
            $table->unsignedInteger('orden_equipo_id')->default('1');
            $table->unsignedInteger('empleado_id');
            $table->string('direccion');
            $table->longText('observaciones');
            $table->string('receptor');
            $table->dateTime('fecha_recepcion')->nullable();
            $table->unsignedInteger('estado_envio_id')->default('1');
            //foreign
            $table->foreign('orden_equipo_id')->references('id')->on('ordenequipo');
            $table->foreign('empleado_id')->references('id')->on('empleados');
            $table->foreign('estado_envio_id')->references('id')->on('estado_envios');
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
        Schema::dropIfExists('registro_envio_equipos');
    }
}
