<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelos';
    protected $fillable = [
      'ModeloNombre',
      'Costo',
      'sort_order',
      'status',
    ];
}
