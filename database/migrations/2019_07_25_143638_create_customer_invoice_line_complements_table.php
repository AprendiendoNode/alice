<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceLineComplementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_line_complements', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('customer_invoice_line_id')->nullable()->unsigned();
          // $table->foreign('customer_invoice_line_id')->references('id')->on('customer_invoice_lines');
          $table->foreign('customer_invoice_line_id', 'cust_inv_id_foreign')->references('id')->on('customer_invoice_lines');

          $table->string('name')->nullable();
          $table->integer('sort_order')->default(0);
          $table->boolean('status')->default(TRUE);
          $table->text('numero_predial')->nullable();

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
        Schema::dropIfExists('customer_invoice_line_complements');
    }
}
