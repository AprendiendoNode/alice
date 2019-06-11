<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class SatProduct extends Model
{
  protected $table = 'sat_products';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
