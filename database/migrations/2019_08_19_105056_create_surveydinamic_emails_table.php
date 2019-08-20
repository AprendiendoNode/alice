<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveydinamicEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveydinamic_emails', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('email');

          $table->bigInteger('survey_id')->unsigned();
          $table->foreign('survey_id')->references('id')->on('surveydinamics');

          $table->Integer('estatus_id')->unsigned();
          $table->foreign('estatus_id')->references('id')->on('estatus');

          $table->boolean('estatus_res')->default(false);

          $table->date('fecha_inicial');
          $table->date('fecha_corresponde');
          $table->date('fecha_fin');

          $table->text('shell_data');
          $table->text('shell_status');
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
        Schema::dropIfExists('surveydinamic_emails');
    }
}
