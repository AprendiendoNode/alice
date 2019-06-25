<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{
  protected $table = 'customer_invoices';

  const PATH_XML_FILES_CI = 'files/customer_invoices/xml';
  const PATH_XML_FILES_CCN = 'files/customer_credit_notes/xml';

  //Por timbrar
  const OPEN = 2; //Abierta
  const PAID = 3; //Pagada
  const CANCEL = 4; //Cancelada
  const RECONCILED = 5; //Conciliada

  protected $fillable = [
    'name',
    'serie',
    'folio',
    'date',
    'date_due',
    'reference',
    'customer_id',
    'branch_office_id',
    'payment_term_id',
    'payment_way_id',
    'payment_method_id',
    'cfdi_use_id',
    'salesperson_id',
    'currency_id',
    'currency_value',
    'amount_discount',
    'amount_untaxed',
    'amount_tax',
    'amount_tax_ret',
    'amount_total',
    'balance',
    'document_type_id',
    'cfdi_relation_id',
    'comment',
    'mail_sent',
    'sort_order',
    'status',
    'confirmacion',
];


}
