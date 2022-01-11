<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRutasVendedorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas_vendedors', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->unsignedInteger('orden_equipo_id')->nullable();
            $table->unsignedInteger('cliente_id');
            $table->unsignedInteger('estado_id')->default('1');
            $table->longText('observaciones');
            $table->unsignedInteger('vendedor_id');
            $table->timestamps();
            //foreign keys
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('orden_equipo_id')->references('id')->on('ordenequipo');
            $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('vendedor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutas_vendedors');
    }
}
