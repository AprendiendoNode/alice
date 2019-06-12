<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $fillable = [
      'Nombre_marca',
      'Distribuidor',
      'sort_order',
      'status',
    ];
}
