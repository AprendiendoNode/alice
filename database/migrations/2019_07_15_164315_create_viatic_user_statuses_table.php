<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViaticUserStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('viatic_user_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('viatic_id')->unsigned();
            $table->foreign('viatic_id')->references('id')->on('viatics');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('viatic_states');

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
        Schema::dropIfExists('viatic_user_statuses');
    }
}
