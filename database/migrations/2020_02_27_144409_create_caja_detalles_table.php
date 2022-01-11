<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('fecha');
            $table->bigInteger('numero')->default('1')->nullable();
            $table->string('anio');
            $table->string('descripcion')->nullable();
            $table->decimal('total', 9,2);
            $table->string('receptor')->nullable();
            $table->boolean('isOpen')->default(true);
            $table->unsignedInteger('caja_maestro_id');
            $table->boolean('isDeleted')->default(false);
            $table->unsignedInteger('estado_id')->default('1');
            $table->unsignedInteger('tipo_movimiento_id');
            //foreign
            $table->foreign('caja_maestro_id')->references('id')->on('caja_maestros');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('tipo_movimiento_id')->references('id')->on('tipo_movimientos');
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
        Schema::dropIfExists('caja_detalles');
    }
}
