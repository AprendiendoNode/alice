<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceLineTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_line_taxes', function (Blueprint $table) {
            // $table->bigIncrements('id');
            // $table->timestamps();
            //
            $table->integer('customer_invoice_line_id')->nullable()->unsigned();
            $table->foreign('customer_invoice_line_id')->references('id')->on('customer_invoice_lines');

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
        Schema::dropIfExists('customer_invoice_line_taxes');
    }
}
