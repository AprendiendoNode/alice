<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosxdiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuariosxdias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('NumClientes');
            $table->date('Fecha');
            $table->string('Mes');
            $table->integer('hotels_id')->unsigned();
            $table->foreign('hotels_id')->references('id')->on('hotels');
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
        Schema::dropIfExists('usuariosxdias');
    }
}
