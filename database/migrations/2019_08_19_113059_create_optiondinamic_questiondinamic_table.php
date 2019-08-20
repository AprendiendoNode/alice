<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptiondinamicQuestiondinamicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optiondinamic_questiondinamic', function (Blueprint $table) {
            // $table->bigIncrements('id');

            $table->bigInteger('optiondinamic_id')->unsigned();
            $table->foreign('optiondinamic_id')->references('id')->on('optiondinamics');

            $table->bigInteger('questiondinamic_id')->unsigned();
            $table->foreign('questiondinamic_id')->references('id')->on('questiondinamics');

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
        Schema::dropIfExists('optiondinamic_questiondinamic');
    }
}
