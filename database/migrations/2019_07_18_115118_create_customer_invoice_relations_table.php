<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_relations', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_invoice_id')->nullable()->unsigned();
            $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices');

            $table->integer('relation_id')->nullable()->unsigned();
            $table->foreign('relation_id')->references('id')->on('customer_invoices');

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
        Schema::dropIfExists('customer_invoice_relations');
    }
}
