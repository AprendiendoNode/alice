<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\State;

class City extends Model
{
  protected $table = 'cities';

  protected $fillable = [
    'name',
    'state_id',
    'sort_order',
    'status',
  ];
  public function states()
  {
    return $this->belongsToMany(State::class);
  }
}
