<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Survey\Questiondinamic;

class Optiondinamic extends Model
{
  public function questiondinamics()
  {
      return $this->belongsToMany(Questiondinamic::class);
  }
}
