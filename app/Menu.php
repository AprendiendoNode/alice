<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Section;
class Menu extends Model
{
  protected $fillable = [
    'name', 'section_id', 'url',
  ];
  public function users()
  {
      return $this->belongsToMany(User::class);
  }
}
