<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_bank_accounts', function (Blueprint $table) {
          $table->increments('id');
          // foranea 1
          $table->integer('customer_id')->nullable()->unsigned();
          $table->foreign('customer_id')->references('id')->on('customers');

          $table->string('name', 100);
          $table->string('account_number', 100);

          //Llave foranea
          $table->integer('bank_id')->nullable()->unsigned();
          $table->foreign('bank_id')->references('id')->on('banks');
          //Llave foranea
          $table->integer('currency_id')->nullable()->unsigned();
          $table->foreign('currency_id')->references('id')->on('currencies');

          $table->integer('sort_order')->default(0);
          $table->boolean('status')->default(true);

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
        Schema::dropIfExists('customer_bank_accounts');
    }
}
