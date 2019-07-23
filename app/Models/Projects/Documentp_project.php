<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class Documentp_project extends Model
{
  protected $table = 'documentp_project_advance';

  protected $fillable = ['id_motivo', 'id_doc'];
}
