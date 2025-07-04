<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\notifikasi;
use Illuminate\Support\Facades\View;
use App\Models\Bimbingan;
class DosenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('dosen')){ 
            $domen_id= session('domen_id');
           $data= notifikasi::select('message')->
           where('domen_id',$domen_id)->where('receiver','dosen')->
           groupBy('message')->where('is_read',false)->get();
        $notifikasi_id= notifikasi::select('notifikasi_id','message')->where('domen_id',$domen_id)->where('receiver','dosen')
        ->where('is_read',false)->orderBy('created_at','desc')->get();
        $jumlah_notifikasi= count($notifikasi_id);
           View::share('dosenNotifikasi',$data);
           view::share('notifikasi_idd',$notifikasi_id);
           view::share('jumlah_notifikasi',$jumlah_notifikasi);
        }
 // ambil data dosen yang sedang login
        // $mahasiswaId = $request->route('id'); // ambil ID mahasiswa dari parameter route
    
        // // Cek apakah dosen tersebut adalah pembimbing dari mahasiswa
        // $isAuthorized = Bimbingan::where('npm', $mahasiswaId)
        //               ->where('domen_id', $domen_id)
        //               ->exists();
   
        // if ($isAuthorized) {
        //     return $next($request); // lanjutkan akses jika berwenang
        // }
    

        
        return $next($request);
    }
}
