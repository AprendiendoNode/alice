<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGbxdiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gbxdias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('CantidadBytes');
            $table->bigInteger('ConsumoReal');
            $table->date('Fecha');
            $table->string('Mes');
            $table->integer('hotels_id')->unsigned();
            $table->foreign('hotels_id')->references('id')->on('hotels');
            // $table->string('Aux')->nullable();
            // $table->string('Aux2')->nullable();
            $table->tinyInteger('Captura');
            $table->integer('ZD')->unsigned();
            $table->foreign('ZD')->references('id')->on('zonedirect_ips');
            $table->integer('days');
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
        Schema::dropIfExists('gbxdias');
    }
}
