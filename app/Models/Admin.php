<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey='id';
    protected $table='admin';
    protected $guard='admin';

    protected $fillable = [
        'id',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
    protected $casts= [
        'password' =>'hashed',
    ];

}
