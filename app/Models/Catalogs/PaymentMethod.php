<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  protected $table = 'payment_methods';
  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
