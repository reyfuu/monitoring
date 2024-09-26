<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class laporan extends Model
{
    use HasFactory;
  
    public $timestamps = false;
    public $incrementing = false;


    protected $primaryKey='laporan_id';
    protected $table='laporan';

    protected $fillable = [
        'laporan_id',
        'judul',
        'tanggal_mulai',
        'tanggal_berakhir',
        'tanggal_submit',
        'deskripsi',
        'domen_id',
        'dokumen',
        'status',
        'type',
        'npm',
    ];

}
