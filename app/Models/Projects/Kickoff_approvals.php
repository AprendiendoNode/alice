<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class Kickoff_approvals extends Model
{
  protected $table = 'kickoff_approvals';
  protected $fillable = ['kickoff_id'];
}
