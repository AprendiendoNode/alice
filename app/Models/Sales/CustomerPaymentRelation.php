<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerPayment;
class CustomerPaymentRelation extends Model
{
    protected $table = 'customer_payment_relations';
    protected $fillable = [
        'customer_payment_id',
        'relation_id',
        'sort_order',
        'status',
        'uuid_related'
    ];
    public function customerPayment()
    {
        return $this->belongsTo(CustomerPayment::class);
    }

    public function relation()
    {
        return $this->belongsTo(CustomerPayment::class,'relation_id','id');
    }
}
