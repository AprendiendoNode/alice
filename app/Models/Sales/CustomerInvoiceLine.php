<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

use App\Models\Sales\CustomerInvoice;
use App\Models\Catalogs\Product;
use App\Models\Catalogs\UnitMeasure;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;
use App\Models\Sales\CustomerInvoiceLineComplement;
class CustomerInvoiceLine extends Model
{
    protected $table = 'customer_invoice_lines';
    protected $fillable = [
      'customer_invoice_id',
      'name',
      'product_id',
      'sat_product_id',
      'unit_measure_id',
      'quantity',
      'price_unit',
      'discount',
      'price_reduce',
      'amount_discount',
      'amount_untaxed',
      'amount_tax',
      'amount_tax_ret',
      'amount_total',
      'sort_order',
      'status',
      'contract_annex_id',
      'currency_id',
      'currency_value'
  ];
  public function scopeActive($query)
  {
      $query->where('status','=','1');
      return $query;
  }
  public function customerInvoice()
  {
      return $this->belongsTo(CustomerInvoice::class);
  }

  public function product()
  {
      return $this->belongsTo(Product::class);
  }

  public function unitMeasure()
  {
      return $this->belongsTo(UnitMeasure::class);
  }

  public function satProduct()
  {
      return $this->belongsTo(SatProduct::class);
  }
  public function taxes()
  {
      return $this->belongsToMany(Tax::class,'customer_invoice_line_taxes');
  }
  public function customerInvoiceLineComplement()
  {
      return $this->hasOne(CustomerInvoiceLineComplement::class);
  }
}
