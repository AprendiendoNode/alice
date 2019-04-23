<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\country_state;
class country extends Model
{
  protected $fillable = [
    'name',
  ];

  public function country_states()
  {
    return $this->hasMany(country_state::class);
  }
}
