<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_bancarias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_cuenta');
            $table->string('no_cuenta');
            $table->unsignedInteger('banco_id')->default('1');
            $table->unsignedInteger('tipo_cuenta_id')->default('1');
            $table->unsignedInteger('estado_id')->default('1');
            $table->timestamps();
            //foreign
            $table->foreign('banco_id')->references('id')->on('bancos');
            $table->foreign('tipo_cuenta_id')->references('id')->on('tipo_cuentas');
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
        Schema::dropIfExists('cuenta_bancarias');
    }
}
