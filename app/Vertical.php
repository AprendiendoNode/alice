<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
use App\Cadena;
class Vertical extends Model
{
  protected $fillable = [
      'name',
      'active',
      'key'
  ];
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
  public function cadenas()
  {
      return $this->belongsToMany(Cadena::class, 'cadena_verticals');
  }
}
