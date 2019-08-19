<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_taxes', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('customer_invoice_id')->nullable()->unsigned();
          $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices');

          $table->string('name',100);

          $table->integer('tax_id')->nullable()->unsigned();
          $table->foreign('tax_id')->references('id')->on('taxes');

          $table->decimal('amount_base',15,5)->nullable()->default(0);
          $table->decimal('amount_tax',15,5)->nullable()->default(0);
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
        Schema::dropIfExists('customer_invoice_taxes');
    }
}
