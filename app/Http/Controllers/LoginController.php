<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session as FacadesSession;

class LoginController extends Controller
{


    use AuthenticatesUsers;
    // function to show form login
    public function index(){
        $data= User::get();
        return view('auth.login',compact('data'));
    }

    // function to auth login
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
            $username= dosen::select('name')->where('email','like','%'.$email.'%')->first()->name;
            $domen_id= dosen::select('domen_id')->where('email','like','%'.$email.'%')->first()->domen_id;
            FacadesSession::put('domen_id',$domen_id);
            $_SESSION['domen']=$username;
            return redirect()->route('dmn.laporan');
        }elseif(Auth::guard('user')->attempt($data)){
            $username= User::where('email','like','%'.$email.'%')->first()->name;
            $npm= User::select('npm')->where('email','like','%'.$email.'%')->first()->npm;
            FacadesSession::put('npm',$npm);
            $_SESSION['mahasiswa']=$username;
            return redirect()->route('mhs.laporan');
        }
        elseif(Auth::guard('admin')->attempt($data)){
            $_SESSION['admin']='admin';
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->route('login')->with('failed','Email or password incorrect');
        }
    }

    // function to logout
    public function logout(){
  
        session_start();
        $_SESSION=[];
        session_unset();
        session_destroy();
        Auth::logout();

        return redirect()->route('login');
    }
}
