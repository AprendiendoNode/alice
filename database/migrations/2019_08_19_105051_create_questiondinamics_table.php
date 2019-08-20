<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestiondinamicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questiondinamics', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->boolean('obligatory')->default(false);
          $table->bigInteger('type_id')->unsigned();
          $table->foreign('type_id')->references('id')->on('typedinamics');
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
        Schema::dropIfExists('questiondinamics');
    }
}
