<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\Helper;
use App\Models\Base\BranchOffice;
use App\Models\Base\DocumentType;

use App\Models\Catalogs\CfdiRelation;
use App\Models\Catalogs\CfdiUse;
use App\Models\Catalogs\Currency;
use App\Models\Catalogs\PaymentMethod;
use App\Models\Catalogs\PaymentTerm;
use App\Models\Catalogs\PaymentWay;

use App\Models\Sales\Salesperson;

use App\Models\Sales\CustomerInvoiceLine;
use App\Models\Sales\CustomerInvoiceTax;
use App\Models\Sales\CustomerInvoiceReconciled;
use App\Models\Sales\CustomerInvoiceRelation;

class CustomerInvoice extends Model
{
  protected $table = 'customer_invoices';

  const PATH_XML_FILES_CI = 'files/customer_invoices/xml';
  const PATH_XML_FILES_CCN = 'files/customer_credit_notes/xml';
  const PATH_XML_FILES_CMP = 'files/customer_complement/xml';
  const PATH_XML_FILES_CTR = 'files/customer_transfers/xml';
  const PATH_XML_FILES_LEA = 'files/customer_leases/xml';
  const PATH_XML_FILES_FEE = 'files/customer_fees/xml';

  //Por timbrar
  const OPEN = 2; //Abierta
  const PAID = 3; //Pagada
  const CANCEL = 4; //Cancelada
  const RECONCILED = 5; //Conciliada
  const CANCEL_PER_AUTHORIZED = 6; //Cancelacion por autorizar en el SAT

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
    'date_delivery',
    'source',
    'source_name',
    'source_taxid',
    'source_address',
    'source_delivery_on',
    'destination',
    'destination_name',
    'destination_taxid',
    'destination_address',
    'destination_delivery_on',
    'valid_amount',
    'dangerous_material',
    'compensation',
    'retainer_name',
    'retainer_taxid',
    'driver',
    'vehicle',
    'vehicle_number',
    'vehicle_counter',
    'cfdi_type2',
    'document_type2',
];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branchOffice()
    {
        return $this->belongsTo(BranchOffice::class);
    }

    public function paymentTerm()
    {
        return $this->belongsTo(PaymentTerm::class);
    }
    public function paymentWay()
    {
        return $this->belongsTo(PaymentWay::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function cfdiUse()
    {
        return $this->belongsTo(CfdiUse::class);
    }
    public function salesperson()
    {
        return $this->belongsTo(Salesperson::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function cfdiRelation()
    {
        return $this->belongsTo(CfdiRelation::class);
    }

    //////-----------------------------------
    public function customerInvoiceLines()
    {
        return $this->hasMany(CustomerInvoiceLine::class);
    }

    public function customerInvoiceLineTransfers()
    {
        return $this->hasMany(CustomerInvoiceLineTransfer::class)->where('status','=','1');
    }

    public function customerInvoiceTaxes()
    {
        return $this->hasMany(CustomerInvoiceTax::class);
    }

    public function customerInvoiceReconcileds()
    {
        return $this->hasMany(CustomerInvoiceReconciled::class);
    }

    public function customerInvoiceRelations()
    {
        return $this->hasMany(CustomerInvoiceRelation::class);
    }

    public function customerInvoiceCfdi()
    {
        return $this->hasOne(CustomerInvoiceCfdi::class);
    }

    public function customerPaymentHistory()
    {
        return $this->hasMany(CustomerPaymentReconciled::class,'reconciled_id')
            ->where('status','=','1')
            ->whereHas('customerPayment', function ($q) {
                $q->whereIn('customer_payments.status', [CustomerPayment::OPEN,CustomerPayment::RECONCILED]);
            });
    }
}
