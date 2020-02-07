<?php

namespace App\Models\Purchases;

use Illuminate\Database\Eloquent\Model;
use App\Models\Purchases\Purchase;

class PurchaseReconciled extends Model
{
  protected $table = 'purchase_reconcileds';
  protected $fillable = [
    'purchase_id',
    'name',
    'reconciled_id',
    'currency_value',
    'amount_reconciled',
    'last_balance',
    'number_of_payment',
    'sort_order',
    'status'
  ];
  public function scopeActive($query)
  {
      $query->where('status','=','1');

      return $query;
  }

  public function purchase()
  {
      return $this->belongsTo(Purchase::class);
  }

  public function reconciled()
  {
      return $this->belongsTo(Purchase::class,'reconciled_id','id');
  }
}
