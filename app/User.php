<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles; //<--Se añade la siguiente linea
use App\Menu;
use App\Cadena;
use App\Workstation;
use App\Department;
class User extends Authenticatable
{
    use Notifiable,SoftDeletes, HasRoles; //<-Se añade el HasRoles
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }
    public function cadenas()
    {
        return $this->belongsToMany(Cadena::class);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
    public function workstations()
    {
        return $this->belongsToMany(Workstation::class);
    }
}
