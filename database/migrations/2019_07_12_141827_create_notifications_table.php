<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); //ID UNICO
            $table->string('type'); //TIPO DE NOTIFICACION
            $table->morphs('notifiable'); //ALMACENA USUARIO O MODELO NOTIFICABLE
            $table->text('data'); //DATO A GUADAR
            $table->timestamp('read_at')->nullable(); //SI ES LEIDO O NO
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
        Schema::dropIfExists('notifications');
    }
}
