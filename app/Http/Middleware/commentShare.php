<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\dosen;
use App\Models\comment;
use App\Models\laporan;
use Illuminate\Support\Facades\View;

class commentShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $npm= session('npm');
        $domen_id= session('domen_id');
        if($npm){
            $commentMahasiswa = comment::select('isi','receiver')->where('npm',$npm)->get();
            $dosen = laporan::join('domen','domen.domen_id','=','laporan.domen_id')->first('domen.name as name');
        

            View::share('commentMahasiswa',$commentMahasiswa);
            View::share('namaDosen',$dosen);
        }elseif($domen_id){
            
            
            $siswa= laporan::distinct()->join('mahasiswa','mahasiswa.npm','=','laporan.npm')->get('mahasiswa.name as name');
            $commentDosen = comment::select('isi','receiver')->where('npm',$npm)->get();
            View::share('namaSiswa',$siswa);
        }


       

        return $next($request);
    }
}
