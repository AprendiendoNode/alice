<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
  protected $table = 'currencies';
  protected $fillable = [
    'name',
    'code',
    'rate',
    'decimal_place',
    'symbol',
    'symbol_position',
    'decimal_mark',
    'thousands_separator',
    'sort_order',
    'status',
  ];
}
