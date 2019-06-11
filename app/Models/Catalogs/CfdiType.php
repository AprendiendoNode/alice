<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiType extends Model
{
  protected $table = 'cfdi_types';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
