<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalespersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salespersons', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email',100)->unique();
          $table->string('phone',100)->nullable();
          $table->string('phone_mobile',100)->nullable();
          $table->decimal('comission_percent',15,4)->default(0);

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
        Schema::dropIfExists('salespersons');
    }
}
