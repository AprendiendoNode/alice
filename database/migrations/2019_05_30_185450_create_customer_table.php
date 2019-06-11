<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('taxid',15)->nullable();
            $table->string('numid',20)->nullable(); //Indentidad fiscal
            $table->string('email',100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('phone_mobile',100)->nullable();

            $table->integer('payment_term_id')->unsigned();
            $table->foreign('payment_term_id')->references('id')->on('payment_terms');

            $table->integer('payment_way_id')->unsigned();
            $table->foreign('payment_way_id')->references('id')->on('payment_ways');

            $table->integer('payment_method_id')->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->integer('cfdi_use_id')->unsigned();
            $table->foreign('cfdi_use_id')->references('id')->on('cfdi_uses');

            $table->integer('salesperson_id')->unsigned();
            $table->foreign('salesperson_id')->references('id')->on('salespersons');

            $table->string('address_1',100)->nullable(); //Direccion
            $table->string('address_2',50)->nullable(); //Num. Ext
            $table->string('address_3',50)->nullable(); //Num Int.
            $table->string('address_4',100)->nullable(); //Colonia
            $table->string('address_5',100)->nullable(); //Localidad
            $table->string('address_6',150)->nullable(); //Referencia

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states');

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->string('postcode',10)->nullable(); //CP
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
