<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PaymentWay extends Model
{
  protected $table = 'payment_ways';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
