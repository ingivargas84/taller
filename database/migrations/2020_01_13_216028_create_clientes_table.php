<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('tipocliente_id')->nullable();
            $table->foreign('tipocliente_id')->references('id')->on('tipo_cliente')->onDelete('cascade');
            
            $table->string('nit')->nullable();
            $table->string('nombre_fiscal')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->date('fecha_imp')->nullable();

            $table->string('nombre_contacto1')->nullable();
            $table->string('puesto_contacto1')->nullable();
            $table->string('telefono_contacto1')->nullable();
            $table->string('correo_contacto1')->nullable();

            $table->string('nombre_contacto2')->nullable();
            $table->string('puesto_contacto2')->nullable();
            $table->string('telefono_contacto2')->nullable();
            $table->string('correo_contacto2')->nullable();          

            $table->unsignedInteger('empleado_id')->default(1);
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');

            $table->unsignedInteger('estado_id')->default(1);
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
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
        Schema::dropIfExists('clientes');
    }
}
