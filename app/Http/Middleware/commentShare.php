<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use App\Models\comment;
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
        $commentMahasiswa = comment::select('isi','receiver')->where('npm',$npm)->get();
        $commentDosen = comment::select('isi','receiver')->where('npm',$npm)->get();

        View::share('commentMahasiswa',$commentMahasiswa);

        return $next($request);
    }
}
