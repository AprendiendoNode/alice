<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_taxes', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('purchase_id')->nullable()->unsigned();
          $table->foreign('purchase_id')->references('id')->on('purchases');

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
        Schema::dropIfExists('purchase_taxes');
    }
}
