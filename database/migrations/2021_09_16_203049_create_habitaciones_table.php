<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHabitacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id(column: 'id_habitacion');
            $table->unsignedBigInteger(column: 'id_categoria');
            $table->integer('num_habitacion');
            $table->float(column: 'precio', total: 6, places: 3);
            $table->foreign('id_categoria')->references('id_categ_habitaciones')->on('categoria_habitaciones');
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
        Schema::dropIfExists('habitaciones');
    }
}
