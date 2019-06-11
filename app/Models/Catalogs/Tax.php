<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
  const TASA = 'Tasa';
  const CUOTA = 'Cuota';
  const EXENTO = 'Exento';

  protected $table = 'taxes';

  protected $fillable = [
    'name',
    'code',
    'rate',
    'factor',
    'sort_order',
    'status'
  ];

}
