<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseReconciledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_reconcileds', function (Blueprint $table) {
          $table->increments('id');

          $table->integer('purchase_id')->nullable()->unsigned();
          $table->foreign('purchase_id')->references('id')->on('purchases');

          $table->text('name');

          $table->integer('reconciled_id')->nullable()->unsigned();
          $table->foreign('reconciled_id')->references('id')->on('purchases');

          $table->decimal('currency_value',15,8)->default(0)->nullable();
          $table->decimal('amount_reconciled',15,5)->default(0);
          $table->decimal('last_balance',15,5)->default(0);
          $table->integer('number_of_payment')->default(1);
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
      Schema::dropIfExists('purchase_reconcileds');
    }
}
