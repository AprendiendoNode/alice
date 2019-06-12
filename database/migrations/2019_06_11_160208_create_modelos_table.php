<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ModeloNombre');
            $table->double('Costo', 15, 8);

            $table->integer('currency_id')->nullable()->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->integer('marca_id')->nullable()->unsigned();
            $table->foreign('marca_id')->references('id')->on('marcas');

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
        Schema::dropIfExists('modelos');
    }
}
