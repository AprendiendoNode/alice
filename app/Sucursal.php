<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
class Sucursal extends Model
{
  protected $fillable = [
    'name', 'address', 'correo', 'phone',
  ];
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
}
