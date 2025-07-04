<?php

namespace App\Http\Controllers;

use App\Models\comment;
use App\Models\dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
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
        $validator= Validator::make($request->all(),[
            'email'=> 'required',
            'password'=> 'required',
        ],[
            'email.required'=> 'email salah',
            'password.required'=> 'password salah'
        ]);


        $data=[
            'email' => $request->email,
            'password' => $request->password,
        ];
    $email= $request->email;
       
        if(Auth::guard('dosen')->attempt($data)){
            $username= dosen::select('name', 'status')->where('email','like','%'.$email.'%')->first();
            $domen_id= dosen::select('domen_id')->where('email','like','%'.$email.'%')->first()->domen_id;
            Session::put('domen_id',$domen_id );
            Session::put('username',$username->name); 
            if($username->status == 'Mentor'){
                return redirect()->route('dmn.dashboardm');
            }else{
                return redirect()->route('dmn.dashboard');
            }
  
        }elseif(Auth::guard('user')->attempt($data)){
            $npm= User::select('npm','name','status')->where('email','like','%'.$email.'%')->first();
            Session::put('npm',$npm->npm );
            Session::put('username',$npm->name );
            if($npm->status == 'Magang' ){
              return redirect()->route('mhs.magang');
            }
            return redirect()->route('mhs.home');
        }
        elseif(Auth::guard('admin')->attempt($data)){
            Session::put('admin','admin' );
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->route('login')->with('failed','Email atau kata sandi salah');
        }
    }

    // function to logout
    public function logout(Request $request){
  
    
        Auth::logout();
        Session::flush();
        $request->session()->flush();
        return redirect()->route('login');
    }
}
