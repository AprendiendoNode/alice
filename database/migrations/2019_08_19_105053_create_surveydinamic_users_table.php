<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveydinamicUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveydinamic_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->Integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('surveydinamic_users');
    }
}
