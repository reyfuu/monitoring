<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Domen;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\User;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

use HasRoles;

class HomeController extends Controller
{
  // function to show dashboard
    public function dashboard(){

        $data=laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen','domen.domen_id','=','laporan.domen_id')
        ->where('laporan.type','Proposal')
        ->get(['mahasiswa.name as mahasiswa','domen.name as domen','laporan.laporan_id as id',
        'laporan.judul as judul','laporan.tanggal_mulai as mulai','laporan.status as status']);
        

        return view('layout.admin.dashboard',compact('data'));
    }
    public function ta(){
      $data=laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
      ->join('domen','domen.domen_id','=','laporan.domen_id')
      ->where('laporan.type','Laporan')
      ->get(['mahasiswa.name as mahasiswa','domen.name as domen','laporan.laporan_id as id',
      'laporan.judul as judul','laporan.tanggal_mulai as mulai','laporan.status as status']);

      return view('layout.admin.ta',compact('data'));
    }
    public function mahasiswa(){
      $data=User::get();
      return view('layout.admin.mahasiswa',compact('data'));
    }
    public function domen(){
      $data=dosen::get();
      return view('layout.admin.domen',compact('data'));
    }

    // function to choose mahasiswa or dosen
    public function create(){
        return view('layout.admin.create.create');
    }
    //  function to navigate to create mahaiswa
    public function create2(){
      $data=dosen::get();
      return view('layout.admin.create.create2',compact('data'));
    }
    // function to navigate to create dosen
    public function create3(){
      return view('layout.admin.create.create3');
    }

    // function to store user
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
        $dosen_id=dosen::select('domen_id')->where('name','like','%'.$name.'%')->first()->domen_id;
        $data2['type']= 'Proposal';
        $data2['domen_id']= $dosen_id;
        $data2['npm']=$request->npm;
        User::create($data);
        laporan::create($data2);
      }


      return redirect()->route('admin.dashboard');
    }
    // function to navigate edit mahasiswa
    public function edit(Request $request,$id){
      $id2= User::find($id);
      $npm= User::select('npm')->where('npm','like','%'.$id.'%')->first()->npm;
      $tanggal_mulai=laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
      $tanggal_berakhir=laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
      return view('layout.admin.edit',compact('id2','tanggal_mulai','tanggal_berakhir'));
    }
    // function to navigate edit dosen
    public function edit2(Request $request,$id){
      $id2= dosen::find($id);
      return view('layout.admin.edit2',compact('id2'));
    }
    // function to update user
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
    // function to delete mahasiswa
    public function delete(Request $request,$id){
      $data=User::find($id);

      if($data){
        $data->delete();
      }

      return redirect()->route('admin.dashboard');
    }
    // function to delete dosen
    public function delete2(Request $request,$id){
      DB::table('domen')->where('domen_id',$id)->delete();


      return redirect()->route('admin.dashboard');
    }
}
