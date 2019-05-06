<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            //Campos
            $table->string('name');
            $table->string('code',3)->unique();
            $table->decimal('rate',15,8)->default(0);
            $table->unsignedInteger('decimal_place')->default(2);
            $table->string('symbol',3)->nullable();
            $table->string('symbol_position',1)->default('L');
            $table->string('decimal_mark',1)->default('.');
            $table->string('thousands_separator',1)->default(',');
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
        Schema::dropIfExists('currencies');
    }
}
