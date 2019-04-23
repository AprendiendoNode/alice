<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
use App\country;
class country_state extends Model
{

  protected $fillable = [
    'name', 'countries_id',
  ];
  public function countries()
  {
      return $this->belongsToMany(country::class);
  }
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
}
