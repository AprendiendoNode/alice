<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_offices', function (Blueprint $table) {
            $table->increments('id');
            // Campos
            $table->string('name');
            $table->string('email',100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('phone_mobile',100)->nullable();
            $table->string('address_1',150)->nullable(); //Direccion
            $table->string('address_2',50)->nullable(); //Num. Ext
            $table->string('address_3',50)->nullable(); //Num Int.
            $table->string('address_4',100)->nullable(); //Colonia
            $table->string('address_5',100)->nullable(); //Localidad
            $table->string('address_6',150)->nullable(); //Referencia

            //Llave foranea
            $table->integer('city_id')->nullable()->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            //Llave foranea
            $table->integer('state_id')->nullable()->unsigned();
            $table->foreign('state_id')->references('id')->on('states');
            //Llave foranea
            $table->integer('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');

            $table->string('postcode',10); //CP
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
        Schema::dropIfExists('branch_offices');
    }
}
