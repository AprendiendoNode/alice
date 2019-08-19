<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_payments', function (Blueprint $table) {
          $table->increments('id');
          // Campos
          $table->string('name',50);
          $table->string('serie',34)->nullable();
          $table->integer('folio')->nullable();
          $table->dateTime('date')->nullable();
          $table->dateTime('date_payment')->nullable();
          $table->string('reference',100)->nullable();

          // foranea 1
          $table->integer('company_bank_account_id')->nullable()->unsigned();
          $table->foreign('company_bank_account_id')->references('id')->on('company_bank_accounts');
          // foranea 2
          $table->integer('customer_id')->nullable()->unsigned();
          $table->foreign('customer_id')->references('id')->on('customers');
          // foranea 3
          $table->integer('customer_bank_account_id')->nullable()->unsigned();
          $table->foreign('customer_bank_account_id')->references('id')->on('customer_bank_accounts');
          // foranea 4
          $table->integer('branch_office_id')->nullable()->unsigned();
          $table->foreign('branch_office_id')->references('id')->on('branch_offices');
          // foranea 5
          $table->integer('payment_way_id')->nullable()->unsigned();
          $table->foreign('payment_way_id')->references('id')->on('payment_ways');
          // foranea 6
          $table->integer('currency_id')->nullable()->unsigned();
          $table->foreign('currency_id')->references('id')->on('currencies');

          $table->decimal('currency_value',15,8)->default(0);
          $table->decimal('amount',15,5)->default(0);
          $table->decimal('balance',15,5)->default(0);

          $table->unsignedInteger('document_type_id')->nullable();
          // foranea 7
          $table->integer('cfdi_relation_id')->nullable()->unsigned();
          $table->foreign('cfdi_relation_id')->references('id')->on('cfdi_relations');

          $table->boolean('cfdi')->default(FALSE);
          $table->text('comment')->nullable();
          $table->boolean('mail_sent')->default(FALSE);
          $table->integer('sort_order')->default(0);
          $table->tinyInteger('status')->default(\App\Models\Sales\CustomerPayment::OPEN);

          $table->string('confirmacion')->nullable();

          $table->text('tipo_cadena_pago')->nullable();
          $table->text('certificado_pago')->nullable();
          $table->text('cadena_pago')->nullable();
          $table->text('sello_pago')->nullable();
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
        Schema::dropIfExists('customer_payments');
    }
}
