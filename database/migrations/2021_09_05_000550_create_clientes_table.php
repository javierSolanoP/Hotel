<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id('id_cliente');
            $table->string(column: 'cedula');
            $table->string(column: 'nombre');
            $table->string(column: 'apellido');
            $table->string(column: 'genero');
            $table->integer(column: 'edad');
            $table->date(column: 'fecha_nacimiento');
            $table->string(column: 'email');
            $table->string(column: 'password');
            $table->string(column: 'telefono');
            $table->string(column: 'sesion');
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
