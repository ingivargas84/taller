<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaMaestrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_maestros', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->decimal('saldo', 9,2);
            $table->unsignedInteger('estado_caja_id')->default('1');
            //foreign key
            $table->foreign('estado_caja_id')->references('id')->on('estado_cajas');
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
        Schema::dropIfExists('caja_maestros');
    }
}
