<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Survey\Questiondinamic;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surveydinamic extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  public function questiondinamics()
  {
    return $this->belongsToMany(Questiondinamic::class);
  }
}
