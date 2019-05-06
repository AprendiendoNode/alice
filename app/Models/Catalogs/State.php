<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use App\Hotel;
use App\Models\Catalogs\country;
use App\Models\Catalogs\City;

class State extends Model
{
  protected $table = 'states';

  protected $fillable = [
    'name',
    'country_id'.
    'sort_order',
    'status',
  ];
  public function countries()
  {
      return $this->belongsToMany(country::class);
  }
  public function hotels()
  {
      return $this->hasMany(Hotel::class);
  }
  public function cities()
  {
    return $this->hasMany(City::class);
  }
}
