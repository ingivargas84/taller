<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenEquipoLlamadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_equipo_llamadas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion', 100);
            $table->integer('user_id');
            $table->string('fecha', 20);
            $table->string('hora', 30);

            $table->unsignedInteger('ordenequipo_id');
            $table->foreign('ordenequipo_id')->references('id')->on('ordenequipo');

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
        Schema::dropIfExists('orden_equipo_llamadas');
    }
}
