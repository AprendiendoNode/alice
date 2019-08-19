<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerInvoice;

class CustomerInvoiceReconciled extends Model
{
  protected $table = 'customer_invoice_reconcileds';

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'customer_invoice_id',
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

  public function customerInvoice()
  {
      return $this->belongsTo(CustomerInvoice::class);
  }

  public function reconciled()
  {
      return $this->belongsTo(CustomerInvoice::class,'reconciled_id','id');
  }
}
