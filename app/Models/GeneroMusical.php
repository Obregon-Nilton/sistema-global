<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneroMusical extends Model
{
    protected $table = 'generos_musicales';
    protected $primaryKey = 'id_genero';
    public $timestamps = false;
    protected $fillable = ['genero'];

    public function interpretaciones(){
        return $this->hasMany(Interpretacion::class, 'genero_id');
    }
}
