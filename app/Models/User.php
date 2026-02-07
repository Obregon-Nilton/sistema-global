<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;
    protected $table = 'users';

    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'email',
        'password',
        'persona_id'
    ];

    protected $casts = [
        'password' => 'hashed',
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }


}
