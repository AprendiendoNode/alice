<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQualificationaasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualificationaas', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->text('email');

          $table->bigInteger('option_id')->unsigned();
          $table->foreign('option_id')->references('id')->on('optiondinamics');

          $table->bigInteger('question_id')->unsigned();
          $table->foreign('question_id')->references('id')->on('questiondinamics');

          // Operaciones de usuario
          $table->integer('users_id')->nullable()->unsigned();
          $table->foreign('users_id')->references('id')->on('users');

          $table->integer('hotels_id')->nullable()->unsigned();
          $table->foreign('hotels_id')->references('id')->on('hotels');

          $table->integer('respuesta')->nullable();
          $table->date('fecha')->nullable();

          $table->integer('survey_id')->nullable()->unsigned();
          $table->foreign('survey_id')->references('id')->on('surveydinamics');

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
        Schema::table('qualificationaas', function (Blueprint $table) {
            //
        });
    }
}
