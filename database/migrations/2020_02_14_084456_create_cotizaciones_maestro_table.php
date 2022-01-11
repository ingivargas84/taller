<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateCotizacionesMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('cotizaciones_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cliente_id')->default('1');
            $table->bigInteger('no_cotizacion')->default('1');
            $table->string('anio');
            $table->date('fecha');
            $table->decimal('total', 9,2);
            $table->unsignedInteger('estado_id')->default('1');
            $table->timestamps();
            // foreign
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('estado_id')->references('id')->on('estados');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones_maestro');
    }
}
