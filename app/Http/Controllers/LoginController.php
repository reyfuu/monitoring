<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use HasRoles;

class LoginController extends Controller
{
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
        $status= $request->email;
        if($status === 'admin@admin'){
            return redirect()->route('admin.create');
        }
        if(Auth::guard('dosen')->attempt($data)){
            return redirect()->route('admin.proposal');
        }elseif(Auth::guard('web')->attempt($data)){
            return redirect()->route('mhs.laporan');
        }
        else{
            return redirect()->route('login')->with('failed','Email or password incorrect');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success','Logout Success');
    }
}
