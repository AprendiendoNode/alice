<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepts', function (Blueprint $table) {
          $table->increments('id');
          //1era llave foranea
          $table->integer('cadena_id')->unsigned();
          $table->foreign('cadena_id')->references('id')->on('cadenas');
          //2da llave foranea
          $table->integer('hotels_id')->unsigned();
          $table->foreign('hotels_id')->references('id')->on('hotels');

          $table->date('fecha_concept')->nullable();
          $table->text('justificacion')->nullable();

          $table->integer('list_concept_id')->unsigned();
          $table->foreign('list_concept_id')->references('id')->on('viatic_list_concepts');

          $table->integer('cantidad');

          $table->string('amount');
          $table->string('total');

          $table->integer('state_concept_id')->unsigned();
          $table->foreign('state_concept_id')->references('id')->on('viatic_state_concepts');

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
        Schema::dropIfExists('concepts');
    }
}
