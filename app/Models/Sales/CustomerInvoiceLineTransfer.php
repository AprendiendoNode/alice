<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceLineTransfer extends Model
{
    protected $table = 'customer_invoice_line_transfers';
    protected $fillable = [
        'customer_invoice_id',
        'name',
        'product_id',
        'weight',
        'm3',
        'liters',
        'packaging',
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
