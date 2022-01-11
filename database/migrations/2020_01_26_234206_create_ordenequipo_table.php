<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenequipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenequipo', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_orden');
            $table->string('no_orden_trabajo')->nullable();
            $table->string('no_comprobante')->nullable();
            $table->boolean('has_guarantee')->default('0');
            $table->unsignedInteger('cliente_id')->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');            

            $table->unsignedInteger('equipo_id')->nullable();
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');

            $table->unsignedInteger('tipo_trabajo_id')->nullable();
            $table->foreign('tipo_trabajo_id')->references('id')->on('tipo_trabajos')->onDelete('cascade');

            $table->unsignedInteger('ubicacion_id')->nullable();
            $table->foreign('ubicacion_id')->references('id')->on('ubicaciones_equipo')->onDelete('cascade');

            $table->unsignedInteger('estado_id')->default(1);
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');

            $table->unsignedInteger('estado_orden_trabajo_id')->default(1);
            $table->foreign('estado_orden_trabajo_id')->references('id')->on('estado_ordenes_trabajo')->onDelete('cascade');

            $table->float('total_cobrar')->nullable();
            
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('observaciones', 500)->nullable();

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
        Schema::dropIfExists('ordenequipo');
    }
}
