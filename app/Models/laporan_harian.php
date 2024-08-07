<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class laporan_harian extends Model
{
    public $timestamps = false;
    public $incrementing= false;

    protected $primaryKey = 'laporan_harian_id';
    protected $table= 'laporan_harian';

    protected $fillable = [
        'laporan_harian_id',
        'status',
        'isi',
        'tanggal',
        'dokumen',
        'domen_id',
        'npm',
        'minggu',
    ];

    use HasFactory;

    public function mahasiswa(){
        return $this->belongsTo(User::class,'npm');
    }
    public function dosen(){
        return $this->belongsTo(dosen::class);
    }
}
