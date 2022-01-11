<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantias', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('no_garantia');
            $table->string('anio');
            $table->date('fecha');
            $table->unsignedInteger('estado_id')->default('1');
            $table->unsignedInteger('cliente_id');
            $table->unsignedInteger('orden_equipo_id');
            //
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('orden_equipo_id')->references('id')->on('ordenequipo');
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
        Schema::dropIfExists('garantias');
    }
}
