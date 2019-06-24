<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Operacione;
use App\Vertical;
use App\Cadena;
use App\Servicio;
use App\Sucursal;
use App\Models\Catalogs\State;

class Hotel extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = [
    'Nombre_hotel',
    'Direccion',
    'Telefono',
    'operaciones_id',
    'vertical_id',
    'cadena_id',
    'servicios_id',
    'sucursal_id',
    'estado_id',
    'filter'
  ];
  public function typereports()
  {
    return $this->belongsToMany(Typereport::class);
  }
  public function operaciones()
  {
      return $this->belongsTo(Operacione::class);
  }
  public function verticals()
  {
      return $this->belongsTo(Vertical::class);
  }
  public function cadenas()
  {
      return $this->belongsTo(Cadena::class);
  }
  public function servicios()
  {
      return $this->belongsTo(Servicio::class);
  }
  public function sucursals()
  {
      return $this->belongsTo(Sucursal::class);
  }
  public function states()
  {
      return $this->belongsTo(State::class);
  }

}
