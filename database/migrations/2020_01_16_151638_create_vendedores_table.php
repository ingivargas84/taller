<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('nit', 20)->nullable();
            $table->string('apellidos');
            $table->string('direccion');
            $table->string('celular', 30);
            $table->string('correo');
            $table->decimal('comision',5,2);
            $table->unsignedInteger('estado_id')->default('1');
            //tabla Estados
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
        Schema::dropIfExists('vendedores');
    }
}
