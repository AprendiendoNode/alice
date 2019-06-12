<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Productstatus extends Model
{
    protected $table = 'products_status';
    protected $fillable = [
      'name',
      'sort_order',
      'status',
    ];
}
