<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportHotelBandasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_hotel_bandas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('hotels_id')->unsigned();
            $table->foreign('hotels_id')->references('id')->on('hotels');
            $table->date('Fecha');
            $table->string('img');
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('report_hotel_bandas');
    }
}
