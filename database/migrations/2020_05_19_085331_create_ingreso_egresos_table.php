<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingreso_egresos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->unsignedInteger('tipo_movimiento_id');
            $table->unsignedInteger('tipo_calculo_id');
            $table->unsignedInteger('campo_pc_id')->nullable();
            $table->unsignedInteger('campo_am_id')->nullable();
            $table->decimal('porcentaje', 9,6)->nullable();
            $table->decimal('cantidad_multiplicar', 9,2)->nullable();
            $table->decimal('cantidad_ingreso_fijo', 9,2)->nullable();
            $table->unsignedInteger('estado_id')->default('1');
            //foreign
            $table->foreign('tipo_movimiento_id')->references('id')->on('mov_ingreso_egresos');
            $table->foreign('tipo_calculo_id')->references('id')->on('tipo_calculos');
            $table->foreign('campo_pc_id')->references('id')->on('valores_por_calculados');
            $table->foreign('campo_am_id')->references('id')->on('valores_fijos');
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
        Schema::dropIfExists('ingreso_egresos');
    }
}
