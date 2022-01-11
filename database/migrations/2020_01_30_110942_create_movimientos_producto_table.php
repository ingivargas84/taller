<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_ingreso');
            $table->unsignedInteger('producto_id')->default('1');
            $table->integer('existencias');
            $table->decimal('precio_compra',9,2);
            $table->decimal('precio_venta',9,2);
            $table->unsignedInteger('estado_id')->default('1');
            //foreigns
            $table->foreign('producto_id')->references('id')->on('productos');
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
        Schema::dropIfExists('movimientos_producto');
    }
}
