<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Questiondinamic;

class Optiondinamic extends Model
{
  public function questiondinamics()
  {
      return $this->belongsToMany(Questiondinamic::class);
  }
}
