<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\State;
class country extends Model
{
  protected $table = 'countries';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];

  public function states()
  {
    return $this->hasMany(State::class);
  }
}
