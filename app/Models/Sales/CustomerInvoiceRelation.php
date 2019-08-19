<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerInvoice;

class CustomerInvoiceRelation extends Model
{
  protected $table = 'customer_invoice_relations';

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = [
    'customer_invoice_id',
    'relation_id',
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

  public function relation()
  {
      return $this->belongsTo(CustomerInvoice::class,'relation_id','id');
  }
}
