<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class evaluasi extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $incrementing= false;
    protected $primaryKey='eval_id';
    protected $table= 'evaluasi';

    protected $fillable = [
        'eval_id',
        'domen_id',
        'npm',
        'tanggal',
        'isi',
        'type'
    ];
}
