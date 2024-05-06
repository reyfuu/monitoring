<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\laporan;
use App\Models\User;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use HasRoles;

class HomeController extends Controller
{
    public function dashboard(){
        $data= User::get();
        return view('dashboard',compact('data'));
    }

    public function index(){
        $data= User::get();
        return view('index',compact('data'));
    }

    public function create(){
        return view('create');
    }
    public function store(Request $request){
      $validator= Validator::make($request->all(),[
        "email"=> "required|email",
        "name"=> "required",
        "password"=> "required",
      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

      $data['email']= $request->email;
      $data['name']= $request->name;
      $data['password']=Hash::make($request->password); 
      $data['status']=$request->status;
      $data2['tanggal_mulai']=$request->tanggal_mulai;

      $status=$request->status;

      if($status== 'dosen' || 'mentor'){
        dosen::create($data);
        laporan::create($data2);
      }else{
        User::create($data);
      }


      return redirect()->route('admin.dashboard');
    }

    public function edit(Request $request,$id){
      $data= User::find($id);

      
      return view('edit',compact('data'));
    }

    public function update(Request $request,$id){

      $validator= Validator::make($request->all(),[
        "email"=> "required|email",
        "name"=> "required",
        "password"=> "nullable",
      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

      $data['email']= $request->email;
      $data['name']= $request->name;
      if($request->passworf){
        $data['password']=Hash::make($request->password); 
      }
      User::whereId($id)->update($data);
      return redirect()->route('admin.dashboard');
    }
    public function delete(Request $request,$id){
      $data=User::find($id);

      if($data){
        $data->delete();
      }

      return redirect()->route('admin.dashboard');
    }
}
