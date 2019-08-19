<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceLineTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_line_transfers', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('customer_invoice_id')->nullable()->unsigned();
          $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices');

          $table->text('name');

          $table->integer('product_id')->nullable()->unsigned();
          $table->foreign('product_id')->references('id')->on('products');

          $table->string('weight')->nullable();
          $table->decimal('m3',15,5)->default(0);
          $table->decimal('liters',15,3)->default(0);
          $table->string('packaging')->nullable();
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
        Schema::dropIfExists('customer_invoice_line_transfers');
    }
}
