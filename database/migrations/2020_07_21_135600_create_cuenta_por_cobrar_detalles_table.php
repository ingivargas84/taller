<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaPorCobrarDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_por_cobrar_detalles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cuenta_cobrar_maestro_id');
            $table->unsignedInteger('tipo_transaccion_id');
            $table->date('fecha_transaccion');
            $table->unsignedInteger('credito_id')->nullable();
            $table->unsignedInteger('abono_id')->nullable();
            $table->decimal('total', 9,2);
            $table->decimal('saldo', 9,2);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('estado_id')->default('1');
            //foreign
            $table->foreign('credito_id')->references('id')->on('ordenequipo');
            $table->foreign('abono_id')->references('id')->on('abonos');
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
        Schema::dropIfExists('cuenta_por_cobrar_detalles');
    }
}
