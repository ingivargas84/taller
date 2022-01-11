<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_comercial');
            $table->string('nombre_legal')->nullable();
            $table->string('nit',20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono', 30)->nullable();
            $table->string('email')->nullable();

            $table->string('nombre_contacto1')->nullable();
            $table->string('puesto_contacto1')->nullable();
            $table->string('telefono_contacto1')->nullable();
            $table->string('correo_contacto1')->nullable();

            $table->string('nombre_contacto2')->nullable();
            $table->string('puesto_contacto2')->nullable();
            $table->string('telefono_contacto2')->nullable();
            $table->string('correo_contacto2')->nullable();
            
            $table->string('observaciones',500)->nullable();
        
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('proveedores');
    }
}
