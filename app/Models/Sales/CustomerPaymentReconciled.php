<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerInvoice;
use App\Models\Sales\CustomerPayment;

class CustomerPaymentReconciled extends Model
{
    protected $table = 'customer_payment_reconcileds';

    protected $fillable = [
          'customer_payment_id',
          'name',
          'reconciled_id',
          'currency_value',
          'amount_reconciled',
          'last_balance',
          'number_of_payment',
          'sort_order',
          'status'
    ];
    public function customerPayment()
    {
        return $this->belongsTo(CustomerPayment::class);
    }

    public function reconciled()
    {
        return $this->belongsTo(CustomerInvoice::class,'reconciled_id','id');
    }
}
