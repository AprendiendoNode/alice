<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
class Servicio extends Model
{
  protected $fillable = [
    'Nombre_servicio',
  ];
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }  
}
