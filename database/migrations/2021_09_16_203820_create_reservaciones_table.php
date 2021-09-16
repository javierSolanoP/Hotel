<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservaciones', function (Blueprint $table) {
            $table->id(column: 'id_reservacion');
            $table->unsignedBigInteger(column: 'id_hotel');
            $table->unsignedBigInteger(column: 'id_usuario');
            $table->unsignedBigInteger(column: 'id_sucursal');
            $table->unsignedBigInteger(column: 'id_habitacion');
            $table->integer(column: 'dias_alojam');
            $table->float(column: 'valor_reserv');
            $table->foreign('id_hotel')->references('id_hotel')->on('hoteles');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios');
            $table->foreign('id_sucursal')->references('id_sucursal')->on('sucursales');
            $table->foreign('id_habitacion')->references('id_habitacion')->on('habitaciones');
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
        Schema::dropIfExists('reservaciones');
    }
}
