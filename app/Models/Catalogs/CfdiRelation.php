<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CfdiRelation extends Model
{
  protected $table = 'cfdi_relations';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
}
