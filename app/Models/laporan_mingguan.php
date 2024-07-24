<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class laporan_mingguan extends Model
{
    public $timestamps = false;
    public $incrementing= false;

    protected $primaryKey = 'laporan_mingguan_id';
    protected $table= 'laporan_mingguan';

    protected $fillable = [
        'laporan_mingguan_id',
        'status',
        'isi',
        'domen_id',
        'npm',
        'week',
    ];

    use HasFactory;


}
