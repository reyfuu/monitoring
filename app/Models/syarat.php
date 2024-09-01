<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class syarat extends Model
{
    use HasFactory;
    public $timestamps= false;
    public $incrementing = false;
    protected $table = 'syarat';
    protected $primaryKey = 'id_syarat';

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
