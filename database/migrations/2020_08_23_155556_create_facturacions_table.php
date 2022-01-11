<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturacions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('no_factura');
            $table->string('serie');
            $table->string('cliente')->nullable();
            $table->string('nit')->nullable();
            $table->date('fecha');
            $table->string('direccion');
            $table->decimal('monto', 9,2);
            $table->string('eliminadaDesc')->nullable();
            $table->unsignedInteger('cliente_id')->nullable();
            $table->unsignedInteger('orden_id');
            $table->unsignedInteger('estado_id')->default('1');
            //foreign
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('orden_id')->references('id')->on('ordenequipo');
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
        Schema::dropIfExists('facturacions');
    }
}
