<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentCfdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payment_cfdis', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('customer_payment_id')->nullable()->unsigned();
          $table->foreign('customer_payment_id')->references('id')->on('customer_payments');

          $table->string('name',100);

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
        Schema::dropIfExists('customer_payment_cfdis');
    }
}
