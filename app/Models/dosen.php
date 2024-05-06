<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;

class dosen extends Model
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
