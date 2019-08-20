<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestiondinamicSurveydinamicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questiondinamic_surveydinamic', function (Blueprint $table) {
            // $table->bigIncrements('id');

            $table->bigInteger('survey_id')->unsigned();
            $table->foreign('survey_id')->references('id')->on('surveydinamics');

            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questiondinamics');

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
        Schema::dropIfExists('questiondinamic_surveydinamic');
    }
}
