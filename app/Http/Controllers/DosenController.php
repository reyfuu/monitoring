<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function proposal(){
        return view('dsn-dashboardp');
    }
    public function proposal2(){
        return view('dsn-proposal');
    }
    public function proposal3(){
        return view('dsn-proposal2');
    }
    public function laporan(){
        return view('dsn-dashboardl');
    }
    public function laporan2(){
        return view('dsn-laporan');
    }
    public function ta(){
        return view('dsn-dashboardt');
    }
    public function ta2(){
        return view('dsn-ta');
    }
    public function ta3(){
        return view('dsn-ta2');
    }
}
