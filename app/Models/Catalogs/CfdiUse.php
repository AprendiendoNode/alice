<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiUse extends Model
{
  protected $table = 'cfdi_uses';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
