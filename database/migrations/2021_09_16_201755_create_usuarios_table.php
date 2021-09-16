<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
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
            $table->string(column: 'avatar')->nullable();
            $table->unsignedBigInteger(column: 'id_role');
            $table->foreign('id_role')->references('id_role')->on('roles');
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
        Schema::dropIfExists('usuarios');
    }
}
