<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosMaestroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_maestro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default('1');
            $table->dateTime('fecha_compra');
            $table->date('fecha_factura');
            $table->unsignedInteger('proveedor_id')->default('1');
            $table->string('serie_factura');
            $table->string('num_factura');
            $table->decimal('total', 9,2);
            $table->unsignedInteger('estado_id')->default('1');
            //foreign
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
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
        Schema::dropIfExists('ingresos_maestro');
    }
}
