<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class dosen extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey='domen_id';
    protected $table='domen';
    protected $guard='dosen';

    protected $fillable = [
        'domen_id',
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
    public function laporanHarian()
    {
        return $this->hasMany(laporan_harian::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
