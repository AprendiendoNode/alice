<?php

namespace App\Models\Sales;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $table = 'customers';

  protected $fillable = [
        'name',
        'taxid',
        'numid',
        'email',
        'payment_term_id',
        'payment_way_id',
        'payment_method_id',
        'cfdi_use_id',
        'salesperson_id',
        'address_1',
        'city_id',
        'state_id',
        'country_id',
        'postcode',
        'sort_order',
        'status'
  ];
}
