<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            //Campos
            $table->string('name');
            $table->string('code',3)->unique();
            $table->decimal('rate',15,8)->default(0);
            $table->enum('factor',[
              \App\Models\Catalogs\Tax::TASA,
              \App\Models\Catalogs\Tax::CUOTA,
              \App\Models\Catalogs\Tax::EXENTO,
            ])->default(\App\Models\Catalogs\Tax::TASA);
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
        Schema::dropIfExists('taxes');
    }
}
