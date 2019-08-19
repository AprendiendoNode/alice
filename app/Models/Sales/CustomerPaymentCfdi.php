<?php

namespace App\Models\Sales;
use App\Models\Base\Pac;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerPayment;

class CustomerPaymentCfdi extends Model
{
    protected $table = 'customer_payment_cfdis';
    protected $fillable = [
      'customer_payment_id',
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
  public function customerPayment()
  {
      return $this->belongsTo(CustomerPayment::class);
  }

  public function pac()
  {
      return $this->belongsTo(Pac::class);
  }
}
