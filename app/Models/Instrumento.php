<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instrumento extends Model
{
    protected $table = 'instrumentos';
    protected $primaryKey = 'id_instrumento';
    public $timestamps = false;
    protected $fillable = ['instrumento', 'nivel', 'categoria'];

    public function interpretaciones(){
        return $this->hasMany(Interpretacion::class, 'instrumento_id');
    }
}
