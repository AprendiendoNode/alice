<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJefedirectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jefedirectos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre');
            $table->string('AreaTrabajo')->nullable();
            $table->string('Telefono')->nullable();
            $table->string('email');
            $table->string('signature')->nullable();
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
        Schema::dropIfExists('jefedirectos');
    }
}
