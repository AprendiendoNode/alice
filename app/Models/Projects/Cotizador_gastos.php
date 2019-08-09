<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Model;

class Cotizador_gastos extends Model
{
    protected $table = 'cotizador_gastos_mensuales';
    protected $fillable = ['cotizador_id'];
}
