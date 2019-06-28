<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
  protected $table = 'banks';

  protected $fillable = [
    'name',
    'code',
    'taxid',
    'sort_order',
    'status',
  ];
}
