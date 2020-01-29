<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseLineTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_line_taxes', function (Blueprint $table) {
            //$table->bigIncrements('id');
            //$table->timestamps();
            $table->integer('purchase_line_id')->nullable()->unsigned();
            $table->foreign('purchase_line_id')->references('id')->on('purchase_lines');

            $table->integer('tax_id')->nullable()->unsigned();
            $table->foreign('tax_id')->references('id')->on('taxes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_line_taxes');
    }
}
