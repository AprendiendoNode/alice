<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaratulacontratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caratulacontrato', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->text('razon_social');
            $table->text('representante');
            $table->text('telefono_contacto');
            $table->text('correo_contacto');
            $table->text('rfc');
            $table->text('cfdi');
            $table->text('direccion');
            $table->text('metodo_pago');
            $table->text('direccion_persona');
            $table->text('atencion_persona');

            $table->text('especificaciones')->nullable();

            $table->text('vigencia');
            $table->decimal('monto_pago',15,5)->default(0);
            $table->text('dias_pago');
            $table->text('moneda_pago');

            $table->text('condiciones_especiales')->nullable();

            $table->text('aplica_garantia');
            $table->text('no_aplica_garantia');
            $table->decimal('monto_garantia',15,5)->default(0);

            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('caratulacontrato');
    }
}
