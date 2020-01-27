<?php

namespace App\Models\Purchases;
use App\Models\Catalogs\Tax;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchases\Purchase;

class PurchaseTax extends Model
{
  protected $table = 'purchase_taxes';
  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'purchase_id',
    'name',
    'tax_id',
    'amount_base',
    'amount_tax',
    'sort_order',
    'status'
  ];
  public function purchase()
  {
      return $this->belongsTo(Purchase::class);
  }

  public function tax()
  {
      return $this->belongsTo(Tax::class);
  }
}
