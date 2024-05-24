<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use HasRoles;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{


    use AuthenticatesUsers;

    public function index(){
        $data= User::get();
        return view('auth.login',compact('data'));
    }
    public function login_proses(Request $request){
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
        ]);

        $data=[
            'email' => $request->email,
            'password' => $request->password,
        ];
        $email= $request->email;
        session_start();
        if(Auth::guard('dosen')->attempt($data)){
            $username= User::where('email','like','%'.$email.'%')->first()->name;
            $_SESSION['domen']=$username;
            return redirect()->route('dmn.laporan');
        }elseif(Auth::guard('user')->attempt($data)){
            $username= User::where('email','like','%'.$email.'%')->first()->name;

            $_SESSION['mahasiswa']=$username;
            return redirect()->route('mhs.laporan');
        }
        elseif(Auth::guard('admin')->attempt($data)){
            $_SESSION['admin']='admin';
            return redirect()->route('admin.create');
        }
        else{
            return redirect()->route('login')->with('failed','Email or password incorrect');
        }
    }


    public function logout(){
  
        session_start();
        $_SESSION=[];
        session_unset();
        session_destroy();
        Auth::logout();

        return redirect()->route('login')->with('success','Logout Success');
    }
}
