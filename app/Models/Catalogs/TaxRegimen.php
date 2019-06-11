<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class TaxRegimen extends Model
{
  protected $table = 'tax_regimens';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
