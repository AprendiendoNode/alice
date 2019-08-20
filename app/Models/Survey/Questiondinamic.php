<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Optiondinamic;
use App\Surveydinamic;
use Illuminate\Database\Eloquent\SoftDeletes;
class Questiondinamic extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  public function surveydinamics()
  {
      return $this->belongsToMany(Surveydinamic::class);
  }
  public function optiondinamics()
  {
      return $this->belongsToMany(Optiondinamic::class);
  }
}
