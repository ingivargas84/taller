<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCuentaProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_cuenta_proveedor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proveedor_id')->default('1');
            $table->unsignedInteger('documento_id')->default('1');
            $table->unsignedInteger('transaccion_id')->default('1');
            $table->unsignedInteger('estado_id')->default('1');
            $table->decimal('total', 9,2);
            //
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('documento_id')->references('id')->on('ingresos_maestro');
            $table->foreign('transaccion_id')->references('id')->on('tipo_transaccion');
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
        Schema::dropIfExists('estado_cuenta_proveedor');
    }
}
