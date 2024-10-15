<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class comment extends Model
{
    
    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey='comment_id';
    protected $table='comments';


    protected $fillable = [
        'comment_id',
        'sender',
        'receiver',
        'npm',
        'domen_id',
        'message',
        'created_at'
    ];

}
