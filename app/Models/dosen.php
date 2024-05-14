<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class dosen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey='domen_id';
    protected $table='domen';
    protected $guard='dosen';

    protected $fillable = [
        'email',
        'name',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts= [
        'password' =>'hashed',
    ];
}
