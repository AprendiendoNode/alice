<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
class Operacione extends Model
{
  protected $fillable = [
    'Nombre_operacion',
  ];
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
}
