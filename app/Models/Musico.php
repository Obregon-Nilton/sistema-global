<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musico extends Model
{
    protected $table = 'musicos';
    protected $primaryKey = 'id_musico';
    public $timestamps = false;

    protected $fillable = [
        'persona_id'
    ];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function Interpretaciones(){
        return $this->hasMany(Interpretacion::class,'musico_id');
    }

}
