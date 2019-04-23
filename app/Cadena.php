<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
use App\Vertical;
use App\User;
class Cadena extends Model
{
  protected $fillable = [
    'name',
  ];
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
  public function verticals()
  {
      return $this->belongsToMany(Vertical::class, 'cadena_verticals');
  }
  public function users()
  {
      return $this->belongsToMany(User::class);
  }
}
