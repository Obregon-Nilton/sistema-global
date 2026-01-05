<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';
    protected $primaryKey = 'id_tema';
    public $timestamps = false;
    protected $fillable = ['tema','letra'];

    public function interpretaciones(){
        return $this->hasMany(Interpretacion::class, 'tema_id');
    }
}
