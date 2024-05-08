<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use HasRoles;

class MahasiswaController extends Controller
{
    public function proposal(){
        return view('mhs-proposal');
    }
    public function laporan3(){
        return view('mhs-laporan3');
    }   
     public function laporan2(){
        return view('mhs-laporan2');
    }
    public function laporan(){
        return view('mhs-laporan');
    }
    public function proposal2(){
        return view('mhs-proposal2');
    }
    public function proposal3(){
        return view('mhs-proposal3');
    }
    public function ta(){
        return view('mhs-ta');
    }
    public function ta2(){
        return view('mhs-ta2');
    }
    public function ta3(){
        return view('mhs-ta3');
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['judul']= $request->judul;
        $data['deskripsi']= $request->deskripsi;
        $data['file']= $request->file;
        $joiningDate = '05/06/2021';
        $AfterSixMonthDate = \Carbon\Carbon::createFromFormat('d/m/Y', 
          $joiningDate)->addMonths(6);
        $todaysDate = \Carbon\Carbon::now();
        $daysDifferent = $todaysDate->diff( $AfterSixMonthDate)->format('%a Days');
        laporan::create($data);

        return redirect()->route('mhs.proposal');
    }
}
