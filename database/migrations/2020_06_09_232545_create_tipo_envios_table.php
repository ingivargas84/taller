<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_envios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_envio');
            $table->string('persona_recibe')->nullable();

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
        Schema::dropIfExists('tipo_envios');
    }
}
