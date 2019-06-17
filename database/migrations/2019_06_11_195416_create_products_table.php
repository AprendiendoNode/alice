<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code',64)->nullable();
            $table->integer('num_parte');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('model',64)->nullable(); //Modelo
            $table->string('manufacturer',64)->nullable(); //Marca
            $table->decimal('price',15,5)->default(0);

            $table->integer('categoria_id')->unsigned();
            $table->foreign('categoria_id')->references('id')->on('categories');

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->integer('modelo_id')->unsigned();
            $table->foreign('modelo_id')->references('id')->on('modelos');

            $table->integer('marca_id')->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas');

            $table->integer('proveedor_id')->unsigned();
            $table->foreign('proveedor_id')->references('id')->on('customers');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('products_status');

            $table->integer('unit_measure_id')->unsigned();
            $table->foreign('unit_measure_id')->references('id')->on('unit_measures');

            $table->integer('sat_product_id')->unsigned();
            $table->foreign('sat_product_id')->references('id')->on('sat_products');

            $table->integer('especifications_id')->unsigned();
            $table->foreign('especifications_id')->references('id')->on('especificacions');

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
        Schema::dropIfExists('products');
    }
}
