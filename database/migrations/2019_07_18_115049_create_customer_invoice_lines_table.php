<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_lines', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_invoice_id')->nullable()->unsigned();
            $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices');

            $table->text('name');

            $table->integer('product_id')->nullable()->unsigned();
            $table->foreign('product_id')->references('id')->on('products');

            $table->integer('sat_product_id')->nullable()->unsigned();
            $table->foreign('sat_product_id')->references('id')->on('sat_products');

            $table->integer('unit_measure_id')->nullable()->unsigned();
            $table->foreign('unit_measure_id')->references('id')->on('unit_measures');

            $table->decimal('quantity',15,5)->default(0);
            $table->decimal('price_unit',15,5)->default(0);
            $table->decimal('discount',15,3)->default(0);
            $table->decimal('price_reduce',15,5)->default(0);
            $table->decimal('amount_discount',15,5)->default(0);
            $table->decimal('amount_untaxed',15,5)->default(0);
            $table->decimal('amount_tax',15,5)->default(0);
            $table->decimal('amount_tax_ret',15,5)->default(0);
            $table->decimal('amount_total',15,5)->default(0);
            $table->integer('sort_order')->default(0);
            $table->boolean('status')->default(TRUE);

            // Operaciones de usuario
            $table->integer('created_uid')->nullable()->unsigned();
            $table->foreign('created_uid')->references('id')->on('users');

            $table->integer('updated_uid')->nullable()->unsigned();
            $table->foreign('updated_uid')->references('id')->on('users');
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
        Schema::dropIfExists('customer_invoice_lines');
    }
}
