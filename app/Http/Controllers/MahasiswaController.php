<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function proposal(){
        return view('proposal');
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['judul']= $request->judul;
        $data['deskripsi']= $request->deskripsi;
        $data['file']= $request->file;

        laporan::create($data);

        return redirect()->route('mhs.proposal');
    }
}
