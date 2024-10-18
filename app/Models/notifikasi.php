<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notifikasi extends Model
{

    use HasFactory;
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey='notifikasi_id';
    protected $table='notifikasi';

    protected $fillable = [
        'npm',
        'domen_id',
        'notifikasi_id',
        'sender',
        'receiver',
        'message',
        'created_at',
        'is_read'
    ];
}
