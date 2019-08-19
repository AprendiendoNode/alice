<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payment_relations', function (Blueprint $table) {
            $table->increments('id');
            // $table->timestamps();
            $table->integer('customer_payment_id')->unsigned();
            $table->foreign('customer_payment_id')->references('id')->on('customer_payments');

            $table->integer('relation_id')->unsigned();
            $table->foreign('relation_id')->references('id')->on('customer_payments');

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
        Schema::dropIfExists('customer_payment_relations');
    }
}
