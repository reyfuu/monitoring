<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\notifikasi;
use Illuminate\Support\Facades\View;
class MahasiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('user')){
            $npm= session('npm');
            $data= notifikasi::select('message')->where('npm',$npm)->where('receiver','mahasiswa')
            ->where('is_read',false)->distinct()->groupBy('message')->get();
            $notikasi_idm= notifikasi::select('notifikasi_id','message')->where('npm',$npm)->where('receiver','mahasiswa')
            ->where('is_read',false)->distinct()->get();
            $jumlah_notifikasim= count($notikasi_idm);
            view::share('mahasiswaNotifikasi',$data);
            view::share('notifikasi_idm',$notikasi_idm);
            view::share('jumalah_notifikasim',$jumlah_notifikasim);
        }
        return $next($request);
    }
}
