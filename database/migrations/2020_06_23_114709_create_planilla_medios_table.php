<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanillaMediosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_medios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('planilla_maestro_id');
            $table->unsignedInteger('empleado_id');
            $table->decimal('total_ingresos', 9,2);
            $table->decimal('total_egresos', 9,2);
            $table->decimal('total_liquido', 9,2);
            //foreign
            $table->foreign('planilla_maestro_id')->references('id')->on('planilla_maestros');
            $table->foreign('empleado_id')->references('id')->on('empleados');
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
        Schema::dropIfExists('planilla_medios');
    }
}
