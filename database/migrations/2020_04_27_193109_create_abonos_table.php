<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_recibo')->nullable();
            $table->year('anio')->nullable();
            $table->date('fecha');
            $table->unsignedInteger('documento_id');
            $table->string('no_documento')->nullable();
            $table->decimal('total', 9,2);
            $table->longText('observaciones')->nullable();
            $table->unsignedInteger('user_id');
            //foreign
            $table->foreign('documento_id')->references('id')->on('documentos');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('abonos');
    }
}
