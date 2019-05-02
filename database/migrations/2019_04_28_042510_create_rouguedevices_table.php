<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouguedevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rouguedevices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('MACRogue')->nullable();
            $table->string('ChannelRogue')->nullable();
            $table->string('TypeRogue')->nullable();
            $table->string('SSIDRogue')->nullable();
            $table->string('Mes');
            $table->integer('hotels_id')->unsigned();
            $table->foreign('hotels_id')->references('id')->on('hotels');
            // $table->string('Aux');
            $table->integer('valor');
            $table->date('fecha');
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
        Schema::dropIfExists('rouguedevices');
    }
}
