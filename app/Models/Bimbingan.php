<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;


    protected $primaryKey='bimbingan_id';
    protected $table='bimbingan';

    protected $fillable = [
        'bimbingan_id',
        'domen_id',
        'topik',
        'isi',
        'status',
        'npm',
        'tanggal',
    ];
}
