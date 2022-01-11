<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_ingreso');
            $table->unsignedInteger('producto_id')->default('1');
            $table->decimal('precio_compra',9,2);
            $table->integer('cantidad');
            $table->decimal('subtotal', 9,2);
            $table->unsignedInteger('ingreso_maestro_id')->default('1');
            $table->unsignedInteger('movimiento_producto_id')->default('1');
            $table->unsignedInteger('estado_id')->default('1');
            //foreigns
            $table->foreign('producto_id')->references('id')->on('productos');
            $table->foreign('ingreso_maestro_id')->references('id')->on('ingresos_maestro');
            $table->foreign('movimiento_producto_id')->references('id')->on('movimientos_producto');
            
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
        Schema::dropIfExists('ingresos_detalle');
    }
}
