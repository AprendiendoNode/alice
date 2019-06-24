<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id');
            // Campos
            $table->string('name');
            $table->string('code',50)->unique();
            $table->string('prefix',34)->nullable();
            $table->integer('current_number')->default(0);
            $table->integer('increment_number')->default(1);
            $table->tinyInteger('nature')->default(\App\Models\Base\DocumentType::NO_NATURE);

            $table->integer('cfdi_type_id')->nullable()->unsigned();
            $table->foreign('cfdi_type_id')->references('id')->on('cfdi_types');

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
        Schema::dropIfExists('document_types');
    }
}
