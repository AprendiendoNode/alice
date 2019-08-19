<?php

namespace App\Models\Sales;
use App\Models\Catalogs\Tax;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerInvoice;

class CustomerInvoiceTax extends Model
{
  protected $table = 'customer_invoice_taxes';
  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'customer_invoice_id',
    'name',
    'tax_id',
    'amount_base',
    'amount_tax',
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

  public function tax()
  {
      return $this->belongsTo(Tax::class);
  }
}
