<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTallerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taller', function (Blueprint $table) {
            $table->increments('id');
            
            $table->unsignedInteger('ordenequipo_id')->nullable();
            $table->foreign('ordenequipo_id')->references('id')->on('ordenequipo')->onDelete('cascade');
            
            $table->date('fecha_diagnostico')->nullable();;
            $table->string('detalle_diagnostico',2000)->nullable();
            $table->unsignedInteger('user_diagnostico_id')->nullable();
            $table->foreign('user_diagnostico_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('fecha_autoriza_rechaza')->nullable();
            $table->integer('autoriza_rechaza')->nullable();
            $table->string('detalle_llamada',2000)->nullable();
            $table->unsignedInteger('user_llamada_id')->nullable();
            $table->foreign('user_llamada_id')->references('id')->on('users')->onDelete('cascade');

            $table->date('fecha_reparacion')->nullable();
            $table->string('trabajos_realizados',2000)->nullable();
            $table->unsignedInteger('user_reparacion_id')->nullable();
            $table->foreign('user_reparacion_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedInteger('estado_taller_id')->nullable();
            $table->foreign('estado_taller_id')->references('id')->on('estados_taller')->onDelete('cascade');
            
            $table->date('fecha_salida_taller')->nullable();

            $table->string('observaciones',2000)->nullable();

            $table->unsignedInteger('user_salida_id')->nullable();
            $table->foreign('user_salida_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('taller');
    }
}
