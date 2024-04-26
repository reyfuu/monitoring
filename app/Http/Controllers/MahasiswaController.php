<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function proposal(){
        return view('proposal');
    }
    public function progress(){
        return view('progress');
    }
}
