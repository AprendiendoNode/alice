<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales\CustomerInvoiceLine;

class CustomerInvoiceLineComplement extends Model
{
    protected $table = 'customer_invoice_line_complements';
    protected $fillable = [
      'customer_invoice_line_id',
      'name',
      'sort_order',
      'status',
      'numero_predial'
    ];

    public function scopeActive($query)
    {
        $query->where('status','=','1');

        return $query;
    }

    public function customerInvoiceLine()
    {
        return $this->belongsTo(CustomerInvoiceLine::class);
    }
}
