<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Pac extends Model
{
  protected $table = 'pacs';
  
  protected $fillable = [
    'name',
    'test',
    'sort_order',
    'status',
  ];
}
