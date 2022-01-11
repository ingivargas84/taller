<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaPorPagarMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_por_pagar_maestros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('proveedor_id');
            $table->unsignedInteger('estado_id')->default('1');
            $table->unsignedInteger('user_id');
            //foreign
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('cuenta_por_pagar_maestros');
    }
}
