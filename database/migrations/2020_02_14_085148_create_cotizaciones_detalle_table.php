<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionesDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('producto_id')->nullable();
            $table->unsignedInteger('servicio_id')->nullable();
            $table->boolean('isProduct');
            $table->integer('cantidad');
            $table->decimal('precio', 9,2);
            $table->unsignedInteger('cotizacion_maestro_id')->default('1');
            $table->decimal('subtotal', 9,2);
            $table->unsignedInteger('estado_id')->default('1');
            //foreign
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('servicio_id')->references('id')->on('servicios');
            $table->foreign('estado_id')->references('id')->on('estados');
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
        Schema::dropIfExists('cotizaciones_detalle');
    }
}
