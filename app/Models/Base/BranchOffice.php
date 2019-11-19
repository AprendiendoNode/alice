<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\City;
use App\Models\Catalogs\State;
use App\Models\Catalogs\country;
class BranchOffice extends Model
{
  protected $table = 'branch_offices';
  protected $fillable = [
        'name',
        'postcode',
        'sort_order',
        'status'
  ];
  public function city()
  {
      return $this->belongsTo(City::class);
  }

  public function state()
  {
      return $this->belongsTo(State::class);
  }

  public function country()
  {
      return $this->belongsTo(country::class);
  }
}
