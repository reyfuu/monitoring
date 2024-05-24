<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Domen;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\User;
use GuzzleHttp\Promise\Create;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

use HasRoles;

class HomeController extends Controller
{
    public function dashboard(){
        $data=User::get();
        $data2=dosen::get();
        $count=user::count();
        return view('layout.admin.dashboard',compact('data','data2','count'));
    }

    public function index(){
        $data= User::get();
        return view('layout.admin.index',compact('data'));
    }

    public function create(){
        return view('layout.admin.create.create');
    }
    public function create2(){
      $data= dosen::get();
      return view('layout.admin.create.create2',compact('data'));
    }
    public function create3(){
      $data= User::get();
      return view('layout.admin.create.create3',compact('data'));
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
      $data2['tanggal_berakhir']=date('d-m-y',strtotime("+3 months"));
      $data2['laporan_id']= IdGenerator::generate(
        ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
      $data2['type']=$request->type;
       
      $status=$request->status;

      if($status== 'Dosen'){
        $data['domen_id']=$request->domen_id;
        dosen::create($data);
      }elseif($status == 'Mentor'){
        $data['domen_id']= IdGenerator::generate(
          ['table'=> 'domen','field'=> 'domen_id','length'=>5,'prefix'=>'MN']);
        dosen::create($data);
      }
      else{
        $data['npm']=$request->npm;
        $name=$request->dosen;
        $dosen_id=dosen::where('name','like','%'.$name.'%')->first()->domen_id;
        $data2['type']= 'proposal';
        $data2['domen_id']= $dosen_id;
        $data2['npm']=$request->npm;
        User::create($data);
        laporan::create($data2);
      }


      return redirect()->route('admin.dashboard');
    }

    public function edit(Request $request,$id){
      $id2= User::find($id);
      $npm= User::where('npm','like','%'.$id.'%')->first()->npm;
      $tanggal_mulai=laporan::where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
      $tanggal_berakhir=laporan::where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
      return view('layout.admin.edit',compact('id2','tanggal_mulai','tanggal_berakhir'));
    }
    public function edit2(Request $request,$id){
      $id2= dosen::find($id);
      return view('layout.admin.edit2',compact('id2'));
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
      if($request->password){
        $data['password']=Hash::make($request->password); 
      }
      $data['status']=$request->status;
      $data2['tanggal_mulai']=$request->tanggal_mulai;
      $data2['tanggal_berakhir']=$request->tanggal_berakhir;
      $status= $request->status;
      if($status== 'Dosen'){
        dosen::find($id)->update($data);
        return redirect()->route('admin.dashboard');
      }elseif($status == 'Mentor'){
        dosen::find($id)->update($data);
        return redirect()->route('admin.dashboard');
      }
      else{
      User::where('npm',$id)->update($data);

      return redirect()->route('admin.dashboard');
      }
    }
    
    public function delete(Request $request,$id){
      $data=User::find($id);

      if($data){
        $data->delete();
      }

      return redirect()->route('admin.dashboard');
    }
    public function delete2(Request $request,$id){
      $data=dosen::find($id);

      if($data){
        $data->delete();
      }

      return redirect()->route('admin.dashboard');
    }
}
