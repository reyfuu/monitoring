<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class syarat extends Model
{
    use HasFactory;
    public $timestamps= false;
    protected $table = 'syarat';
    protected $primaryKey = 'syarat_id';

    protected $fillable = [
        'id_syarat',
        'npm',
        'file',
        'dateupload',
        'dateacc',
        'status',
        'syarat',
    ];

}
