<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $table = 'products';
  protected $fillable = [
    'name',
    'num_parte',
    'sort_order',
    'status'
];

  public function unitMeasure()
  {
    return $this->belongsTo(UnitMeasure::class);
  }

  public function satProduct()
  {
    return $this->belongsTo(SatProduct::class);
  }

  public function taxes()
  {
    return $this->belongsToMany(Tax::class,'product_taxes');
  }
}
