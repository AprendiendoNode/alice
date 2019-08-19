<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoiceCfdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_cfdis', function (Blueprint $table) {
          $table->increments('id');
          // foranea 1
          $table->integer('customer_invoice_id')->nullable()->unsigned();
          $table->foreign('customer_invoice_id')->references('id')->on('customer_invoices');

          $table->string('name',100);
          // foranea 2
          $table->integer('pac_id')->nullable()->unsigned();
          $table->foreign('pac_id')->references('id')->on('pacs');

          $table->string('cfdi_version',100)->nullable();
          $table->string('uuid')->nullable();
          $table->dateTime('date')->nullable();
          $table->string('file_xml')->nullable();
          $table->string('file_xml_pac')->nullable();
          $table->dateTime('cancel_date')->nullable();
          $table->text('cancel_response')->nullable();
          $table->string('cancel_state')->nullable();
          $table->integer('sort_order')->default(0);
          $table->boolean('status')->default(TRUE);

          // Operaciones de usuario
          $table->integer('created_uid')->nullable()->unsigned();
          $table->foreign('created_uid')->references('id')->on('users');

          $table->integer('updated_uid')->nullable()->unsigned();
          $table->foreign('updated_uid')->references('id')->on('users');
          // Marcas de tiempo
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
        Schema::dropIfExists('customer_invoice_cfdis');
    }
}
