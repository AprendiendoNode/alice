<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PaymentTerm extends Model
{
  protected $table = 'payment_terms';
  protected $fillable = [
    'name',
    'days',
    'sort_order',
    'status',
  ];
}
