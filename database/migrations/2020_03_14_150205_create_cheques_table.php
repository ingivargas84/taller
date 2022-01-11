<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->decimal('cantidad', 9,2);
            $table->string('no_cheque');
            $table->string('descripcion');
            $table->string('receptor');
            $table->string('referencia');
            $table->unsignedInteger('usuario_id');
            $table->string('persona_acepta');
            $table->unsignedInteger('cuenta_bancaria_id')->default('1');
            $table->unsignedInteger('estado_cheque_id')->default('1');
            $table->timestamps();
            //foreign
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->foreign('cuenta_bancaria_id')->references('id')->on('cuenta_bancarias');
            $table->foreign('estado_cheque_id')->references('id')->on('estado_cheques');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheques');
    }
}
