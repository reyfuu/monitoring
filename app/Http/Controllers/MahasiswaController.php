<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use HasRoles;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function proposal(){
        return view('layout.mhs.proposal.proposal');
    }
    public function proposal2(){
        return view('layout.mhs.proposal.proposal2');
    }
    public function proposal3(){
        return view('layout.mhs.proposal.proposal3');
    }
    public function laporan3(){
        return view('layout.mhs.laporan.laporan3');
    }   
     public function laporan2(){
        return view('layout.mhs.laporan.laporan2');
    }
    public function laporan(){
        return view('layout.mhs.laporan.laporan3');
    }
    public function ta(){
        return view('layout.mhs.ta.ta');
    }
    public function ta2(){
        return view('layout.mhs.ta.ta2');
    }
    public function ta3(){
        return view('layout.mhs.ta.ta3');
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $laporan_id= IdGenerator::generate(
            ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
        $data['judul']= $request->judul;
        $data['deskripsi']= $request->deskripsi;
        $dokumen= $request->file('file');
        $filename=$dokumen->getClientOriginalName();
        $path='dokumen/'.$filename;

        Storage::disk('public')->put($path,file_get_contents($dokumen));
        $data['laporan_id']=$laporan_id;
        $data['dokumen']=$filename;

        laporan::create($data);

        return redirect()->route('mhs.proposal');
    }
}
