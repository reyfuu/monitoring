<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function proposal(){
        return view('layout.dsn.proposal.proposal');
    }
    public function proposal2(){
        return view('layout.dsn.proposal.proposal');
    }
    public function proposal3(){
        return view('layout.dsn.proposal.proposal2');
    }
    public function laporan(){
        return view('layout.dsn.dashboardl');
    }
    public function laporan2(){
        return view('layout.dsn.laporan.laporan');
    }
    public function ta(){
        return view('layout.dsn.dashboardt');
    }
    public function ta2(){
        return view('layout.dsn.ta.ta');
    }
    public function ta3(){
        return view('layout.dsn.ta.ta2');
    }
}
