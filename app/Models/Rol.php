<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = ['nombre'];
    protected $primaryKey = 'id_rol';
    protected $table = 'rols';
    public $timestamps = false;

    public function personas(){
        return $this->hasMany(Persona::class, 'rol_id');
    }

}
