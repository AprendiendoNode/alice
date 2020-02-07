<?php

namespace App\Models\Purchases;

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

use App\Models\Purchases\PurchaseLine;
use App\Models\Purchases\PurchaseTax;

class Purchase extends Model
{
  protected $table = 'purchases';

  //Por timbrar
  const ELABORADO = 1; //ELABORADO
  const REVISADO = 2;  //REVISADO
  const AUTORIZADO = 3;//AUTORIZADO
  const CANCELADO = 4; //CANCELADO

  protected $fillable = [
    'name',
    'serie',
    'folio',
    'date',
    'date_due',
    'date_fact',
    'name_fact',
    'fact_url',
    'xml_url',
    'reference',
    'payment_term_id',
    'payment_way_id',
    'payment_method_id',
    'cfdi_use_id',
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
    'created_uid',
    'updated_uid'
];

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
public function purchaseLine()
{
    return $this->hasMany(PurchaseLine::class);
}
public function purchaseTax()
{
    return $this->hasMany(PurchaseTax::class);
}


}
