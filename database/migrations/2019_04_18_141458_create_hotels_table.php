<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre_hotel', 191);
            $table->string('Direccion', 200);
            $table->string('Telefono', 191);

            $table->string('dirlogo1', 100)->nullable();
            $table->text('Fecha_inicioP')->nullable();
            $table->text('Fecha_terminoP')->nullable();
            $table->string('clave_geoestadistica')->nullable();

            $table->text('Latitude')->nullable();
            $table->text('Longitude')->nullable();
            $table->integer('RM')->nullable();
            $table->integer('ActivarCalificacion')->nullable();
            $table->integer('ActivarReportes')->nullable();
            $table->integer('ActivarDashboard')->nullable();

            //Primera llave foranea
            $table->integer('operaciones_id')->unsigned();
            $table->foreign('operaciones_id')->references('id')->on('operaciones');
            //Segunda llave foranea
            $table->integer('vertical_id')->unsigned();
            $table->foreign('vertical_id')->references('id')->on('verticals');
            //Tercera llave foranea
            $table->integer('cadena_id')->unsigned();
            $table->foreign('cadena_id')->references('id')->on('cadenas');
            //Cuarta llave foranea
            $table->integer('servicios_id')->unsigned();
            $table->foreign('servicios_id')->references('id')->on('servicios');
            //Quinta llave foranea
            $table->integer('sucursal_id')->unsigned();
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
            //Sexta llave foranea
            $table->integer('estado_id')->unsigned();
            $table->foreign('estado_id')->references('id')->on('country_states');

            $table->string('id_proyecto', 20)->nullable();
            $table->string('key', 200)->nullable();
            $table->string('id_ubicacion', 200)->nullable();

            $table->string('calle', 200)->nullable();
            $table->string('num_ext', 100)->nullable();
            $table->string('num_int', 100)->nullable();
            $table->string('codigopostal', 12)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hotels');
    }
}
