<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id(column: 'id_sucursal');
            $table->unsignedBigInteger(column: 'id_hotel');
            $table->string(column: 'direccion', length: 100);
            $table->string(column: 'telefono', length: 10);
            $table->date(column: 'fecha_creacion');
            $table->foreign('id_hotel')->references('id_hotel')->on('hoteles');
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
        Schema::dropIfExists('sucursales');
    }
}
