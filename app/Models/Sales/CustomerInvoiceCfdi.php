<?php

namespace App\Models\Sales;
use App\Models\Base\Pac;
use App\Models\Sales\CustomerInvoice;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceCfdi extends Model
{
  protected $table = 'customer_invoice_cfdis';
  protected $fillable = [
    'customer_invoice_id',
    'name',
    'pac_id',
    'cfdi_version',
    'uuid',
    'date',
    'file_xml',
    'file_xml_pac',
    'cancel_date',
    'cancel_response',
    'cancel_state',
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

  public function pac()
  {
      return $this->belongsTo(Pac::class);
  }
}
