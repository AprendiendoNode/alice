<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\State;
class country extends Model
{
  protected $table = 'countries';

  protected $fillable = [
    'name',
    'code',
    'sort_order',
    'status',
  ];
  /**
   * Funcion para busqueda general
   *
   * @param $query
   * @param array $input
   * @return mixed
   */
  public function scopeFilter($query, array $input = [])
  {
      if (!empty($input['filter_search'])) {
          $search = $input['filter_search'];
          $query->orWhere('name', 'like', '%' . str_replace(' ', '%%', $search) . '%');
          $query->orWhere('code', 'like', '%' . str_replace(' ', '%%', $search) . '%');
      }

      return $query;
  }

  /**
   * Funcion para llenado de datos en un select
   *
   * @param $query
   * @return mixed
   */
  public function scopePopulateSelect($query)
  {
      $query->where('status', '=', '1');
      $query->orderBy('sort_order');
      $query->orderBy('name');

      return $query;
  }
  public function states()
  {
    return $this->hasMany(State::class);
  }

  public static function getStateCountry($id)
  {
    return State::where('id', '=', $id);
  }
  public function getNameSatAttribute()
  {
      return '[' . $this->code . '] ' . $this->name;
  }
}
