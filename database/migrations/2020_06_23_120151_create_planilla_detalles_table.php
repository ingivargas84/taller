<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('planilla_medio_id');
            $table->unsignedInteger('movimiento_id');
            $table->decimal('subtotal', 9,2);
            //foreign
            $table->foreign('planilla_medio_id')->references('id')->on('planilla_medios');
            $table->foreign('movimiento_id')->references('id')->on('ingreso_egresos');
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
        Schema::dropIfExists('planilla_detalles');
    }
}
