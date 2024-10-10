<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class comment extends Model
{
    
    use HasFactory;
    public $timestamps = false;

    public $incrementing = false;
    protected $table='comment';

    protected $primaryKey='comment_id';


    protected $fillable = [
        'comment_id',
        'domen_id',
        'npm',
        'tanggal',
        'isi',
        'sender',
        'receiver',
    ];
}
