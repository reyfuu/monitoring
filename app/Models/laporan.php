<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporan extends Model
{
    use HasFactory;
  
    public $timestamps = false;

    protected $table='laporan';

    protected $fillable = [
        'judul',
        'tanggal_mulai',
        'tanggal_berakhir',
        'deskripsi',
        'id domen',
        'npm',
    ];
}
