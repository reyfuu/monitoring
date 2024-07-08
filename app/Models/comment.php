<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class comment extends Authenticatable
{
    public $timestamps = false;

    use HasFactory;
    public $incrementing = false;


    protected $primaryKey='comment_id';
    protected $table='comment';

    protected $fillable = [
        'comment_id',
        'domen_id',
        'npm',
        'tanggal',
        'isi',
    ];
}
