<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoices', function (Blueprint $table) {
            $table->increments('id');
            // Campos
            $table->string('name',50)->unique();
            $table->string('serie',34)->nullable();
            $table->integer('folio')->nullable();
            $table->dateTime('date')->nullable();
            $table->date('date_due')->nullable();
            $table->string('reference',100)->nullable();

            $table->integer('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->integer('branch_office_id')->nullable()->unsigned();
            $table->foreign('branch_office_id')->references('id')->on('branch_offices');

            $table->integer('payment_term_id')->nullable()->unsigned();
            $table->foreign('payment_term_id')->references('id')->on('payment_terms');

            $table->integer('payment_way_id')->nullable()->unsigned();
            $table->foreign('payment_way_id')->references('id')->on('payment_ways');

            $table->integer('payment_method_id')->nullable()->unsigned();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->integer('cfdi_use_id')->nullable()->unsigned();
            $table->foreign('cfdi_use_id')->references('id')->on('cfdi_uses');

            $table->integer('salesperson_id')->nullable()->unsigned();
            $table->foreign('salesperson_id')->references('id')->on('salespersons');

            $table->integer('currency_id')->nullable()->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->decimal('currency_value',15,8)->default(0);
            $table->decimal('amount_discount',15,5)->default(0);
            $table->decimal('amount_untaxed',15,5)->default(0);
            $table->decimal('amount_tax',15,5)->default(0);
            $table->decimal('amount_tax_ret',15,5)->default(0);
            $table->decimal('amount_total',15,5)->default(0);
            $table->decimal('balance',15,5)->default(0);

            $table->integer('document_type_id')->nullable()->unsigned();
            $table->foreign('document_type_id')->references('id')->on('document_types');

            $table->integer('cfdi_relation_id')->nullable()->unsigned();
            $table->foreign('cfdi_relation_id')->references('id')->on('cfdi_relations');

            $table->text('comment')->nullable();
            $table->boolean('mail_sent')->default(FALSE);
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(\App\Models\Sales\CustomerInvoice::OPEN);
            $table->string('confirmacion')->nullable();

            $table->date('date_delivery')->nullable();
            $table->string('source')->nullable();
            $table->text('source_name')->nullable();
            $table->text('source_taxid')->nullable();
            $table->text('source_address')->nullable();
            $table->text('source_delivery_on')->nullable();
            $table->string('destination')->nullable();
            $table->string('destination_name')->nullable();
            $table->string('destination_taxid')->nullable();
            $table->text('destination_address')->nullable();
            $table->text('destination_delivery_on')->nullable();
            $table->decimal('valid_amount',15,5)->default(0);
            $table->boolean('dangerous_material')->default(FALSE);
            $table->string('compensation')->nullable();
            $table->string('retainer_name')->nullable();
            $table->string('retainer_taxid')->nullable();
            $table->string('driver')->nullable();
            $table->string('vehicle')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('vehicle_counter')->nullable();
            $table->string('cfdi_type2')->nullable(); //invoice, transfer, lease, fee, credit_note, payment
            $table->string('document_type2')->nullable(); //invoice, transfer


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
        Schema::dropIfExists('customer_invoices');
    }
}
