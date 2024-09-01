<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey='npm';
    protected $table= 'mahasiswa';
    protected $guard='mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'npm',
        'name',
        'email',
        'password',
        'status',
        'angkatan',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function laporanHarian()
    {
        return $this->hasMany(laporan_harian::class,'npm');
    }
    public function bimbingans(){
        return $this->hasMany(Bimbingan::class);
    }
    public function isKonsultasiSelesai(){
        return $this->bimbingans()->count()>=14; 
    }


}
