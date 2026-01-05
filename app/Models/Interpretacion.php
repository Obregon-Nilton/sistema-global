<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interpretacion extends Model
{
    protected $table = 'interpretaciones';
    protected $primaryKey = 'id_interpretacion';
    public $timestamps = false;
    protected $fillable = ['estado','nota_id','artista_id','instrumento_id','tema_id','genero_id','musico_id'];
/**  */
    public function notaMusical(){
        return $this->belongsTo(NotaMusical::class, 'nota_id');
    }

    public function artista(){
        return $this->belongsTo(Artista::class, 'artista_id');
    }

    public function instrumento(){
        return $this->belongsTo(Instrumento::class, 'instrumento_id');
    }

    public function tema(){
        return $this->belongsTo(Tema::class, 'tema_id');
    }

    public function generosMusicales(){
        return $this->belongsTo(GeneroMusical::class, 'genero_id');
    }

    public function musico(){
        return $this->belongsTo(Musico::class, 'musico_id');
    }

}
