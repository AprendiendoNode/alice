<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Menu;

class Section extends Model
{
  protected $fillable = [
    'name',
  ];
  public function menus()
  {
    return $this->hasMany(Menu::class);
  }
}
