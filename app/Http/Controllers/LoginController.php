<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
       
        if(Auth::guard('dosen')->attempt($data)){
            $username= dosen::select('name')->where('email','like','%'.$email.'%')->first()->name;
            $domen_id= dosen::select('domen_id')->where('email','like','%'.$email.'%')->first()->domen_id;
        //    $request->session()->put(['domen_id',$domen_id,'domen',$username]);
            return redirect()->route('dmn.dashboard');
        }elseif(Auth::guard('user')->attempt($data)){
            $npm= User::select('npm','name')->where('email','like','%'.$email.'%')->first();
            Session::put('npm',$npm->npm );
            Session::put('username',$npm->name );



            return redirect()->route('mhs.home');
        }
        elseif(Auth::guard('admin')->attempt($data)){
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->route('login')->with('failed','Email or password incorrect');
        }
    }

    // function to logout
    public function logout(Request $request){
  
        if($request->session()->has('npm')){
            $request->session()->forget('npm');
        }elseif($request->session()->has('domen')){
            $request->session()->forget('domen');
        }
  

        Auth::logout();

        return redirect()->route('login');
    }
}
