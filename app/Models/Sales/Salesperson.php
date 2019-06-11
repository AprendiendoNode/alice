<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Salesperson extends Model
{
  protected $table = 'salespersons';

  protected $fillable = [
    'name',
    'first_name',
    'last_name',
    'email',
    'phone',
    'phone_mobile',
    'comission_percent',
    'sort_order',
    'status',
  ];
}
