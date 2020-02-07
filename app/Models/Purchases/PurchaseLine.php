<?php

namespace App\Models\Purchases;

use Illuminate\Database\Eloquent\Model;

use App\Models\Purchases\Purchase;
use App\Models\Catalogs\Product;
use App\Models\Catalogs\UnitMeasure;
use App\Models\Catalogs\SatProduct;
use App\Models\Catalogs\Tax;

class PurchaseLine extends Model
{
  protected $table = 'purchase_lines';
  protected $fillable = [
    'purchase_id',
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
    'currency_id',
    'currency_value',
    'cuentas_contable_id',
    'sitio_id',
    'created_uid',
    'updated_uid'
  ];
  public function purchase()
  {
      return $this->belongsTo(Purchase::class);
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
      return $this->belongsToMany(Tax::class,'purchase_line_taxes');
  }
}
