<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class dosen extends Authenticatable
{
    public $timestamps = false;

    protected $table='domen';
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts= [
        'password' =>'hashed',
    ];
}
