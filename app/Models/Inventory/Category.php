<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
      'name',
      'sort_order',
      'status',
    ];
}
