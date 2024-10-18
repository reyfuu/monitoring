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
            $data= notifikasi::where('npm',$npm)->where('receiver','mahasiswa')->where('is_read',false)->get();
            view::share('mahasiswaNotifikasi',$data);
        }
        return $next($request);
    }
}
