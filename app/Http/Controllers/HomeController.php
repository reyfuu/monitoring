<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Domen;
use App\Models\Bimbingan;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\syarat;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
// use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use HasRoles;

class HomeController extends Controller
{
  // function to show dashboard
    public function dashboard(){

        $data=laporan::distinct()->join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen','domen.domen_id','=','laporan.domen_id')
        ->join('bimbingan','bimbingan.npm','=','bimbingan.npm')
        ->where('laporan.type','Proposal')
        ->get(['mahasiswa.name as mahasiswa','domen.name as domen','laporan.laporan_id as id',
        'laporan.judul as judul','laporan.tanggal_mulai as mulai','laporan.status as status'
          ,'laporan.status_domen as status_domen','mahasiswa.npm as npm']);
        
        return view('layout.admin.dashboard',compact('data'));
    }
    public function bimbingan($id){
      $data= Bimbingan::join('domen','domen.domen_id','=','bimbingan.domen_id')->where('bimbingan.npm',$id)->
      where('type','Proposal')->
      get(['domen.name as name','bimbingan.tanggal as tanggal','bimbingan.topik as topik'
      ,'bimbingan.status as status','bimbingan.bimbingan_id as id']);

      return view('layout.admin.bimbingan',compact('data'));
    }
    public function bimbingan2($id){
      $data= Bimbingan::join('domen','domen.domen_id','=','bimbingan.domen_id')->where('bimbingan.npm',$id)->
      where('type','Tugas AKhir')->
      get(['domen.name as name','bimbingan.tanggal as tanggal','bimbingan.topik as topik'
      ,'bimbingan.status as status','bimbingan.bimbingan_id as id']);

      return view('layout.admin.bimbingan2',compact('data'));
    }
    public function ta(){
      $data=laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
      ->join('domen','domen.domen_id','=','laporan.domen_id')
      ->where('laporan.type','Tugas Akhir')
      ->get(['mahasiswa.name as mahasiswa','domen.name as domen','laporan.laporan_id as id',
      'laporan.judul as judul','laporan.tanggal_mulai as mulai','laporan.status as status',
      'laporan.status_domen as status_domen','mahasiswa.npm as npm']);

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
        "npm"=>"required|unique:mahasiswa,npm",
        "name"=>"required",
        "email"=> "required|email",
        "name"=> "required",
        "status"=>"required",
        "password"=> "required",
        "dosen"=> "required",
        "tanggal_mulai"=>"required",
        "angkatan"=>"required"
      ],[
          'npm.unique'=> 'npm sudah diambil',
          'npm.required'=>'Masukkan  npm',
          'name.required'=>'Masukkan nama',
          'email.required'=> 'Masukkan email',
          'status.required'=>'Masukkan status',
          'password.required'=>'Masukkan password',
          'dosen.required'=>'Pilih Dosen Pembimbing',
          'angkatan.required'=> 'Masukkan angkatan',
          'tanggal_mulai.required'=> 'Pilih tanggal mulainya'

      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
      
      $data['email']= $request->email;
      $data['name']= $request->name;
      $data['password']=Hash::make($request->password); 
      $data['status']=$request->status;
      $data2['tanggal_mulai']=$request->tanggal_mulai;
      $data2['tanggal_berakhir']=date('Y-m-d',strtotime("+6 months"));
      $data2['laporan_id']= IdGenerator::generate(
        ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
       
      $status=$request->status;

     
      if($status == 'Magang'){
        $data['npm']=$request->npm;
        $data['angkatan']=$request->angkatan;
        User::create($data);
        $name=$request->dosen;
        $dosen_id=dosen::select('domen_id')->where('name','like','%'.$name.'%')->first()->domen_id;
        $data2['type']= 'Laporan Akhir';
        $data2['domen_id']= $dosen_id;
        $data2['npm']=$request->npm;
        $data2['status']= 'belum submit';
        laporan::create($data2);
       return redirect()->route('admin.mahasiswa');
      }
      // elseif($status == 'Magang'){
      //   $data['npm']= $request->npm;
      //   $data['email']= $request->email;
      //   $data['password']= Hash::make($request->password);
      // }
      else{
        $data['npm']=$request->npm;
        $name=$request->dosen;
        $dosen_id=dosen::select('domen_id')->where('name','like','%'.$name.'%')->first()->domen_id;
        $data2['type']= 'Proposal';
        $data2['domen_id']= $dosen_id;
        $data2['npm']=$request->npm;
        $data2['status']= 'belum submit';
        $data['angkatan']=$request->angkatan;
        User::create($data);
        laporan::create($data2);

        $data3['tanggal_mulai']=$request->tanggal_mulai;
        $data3['tanggal_berakhir']=date('Y-m-d',strtotime("+6 months"));
        $data3['laporan_id']= IdGenerator::generate(
          ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
          $data3['type']= 'Tugas Akhir';
          $data3['domen_id']= $dosen_id;
          $data3['npm']=$request->npm;
          $data3['status']= 'belum submit';
          laporan::create($data3);

 
            return redirect()->route('admin.mahasiswa');
      }
  

      //   dd($data3);
     
    }
    public function store2(Request $request){
      $validator= Validator::make($request->all(),[
        "domen_id"=>'required',
        "name"=>'required',
        "email"=>'required',
        "password"=> 'required',
        "status"=>'required',
      ],[
        "domen_id.required"=>'Masukkan isi kolom nidnnya',
        "name.required"=>'Masukkan isi kolom namanya',
        "email.required"=>'Masukkan isi kolom emailnya',
        'password.required'=>'Masukkan isi kolom password',
        'status.required'=>'Masukkan pilih statusnya'
      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
      $status=$request->status;
      $data['email']= $request->email;
      $data['name']= $request->name;
      $data['password']=Hash::make($request->password); 
      $data['status']=$request->status;
      if($status== 'Dosen'){
        $data['domen_id']=$request->domen_id;
        dosen::create($data);
      }elseif($status == 'Mentor'){
        $data['domen_id']= IdGenerator::generate(
          ['table'=> 'domen','field'=> 'domen_id','length'=>5,'prefix'=>'MN']);
        dosen::create($data);
    }
    return redirect()->route('admin.domen');
  }
    
    // function to navigate edit mahasiswa
    public function edit(Request $request,$id){
      $id2= User::find($id);
      $npm= User::select('npm')->where('npm','like','%'.$id.'%')->first()->npm;
      $tanggal_mulai=laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
      $tanggal_berakhir=laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
      $data=dosen::get();
      return view('layout.admin.edit',compact('id2','tanggal_mulai','tanggal_berakhir','data'));
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
        "password"=> "required",
        'status'=>"required",
        'dosen'=> 'required'
      ],[
        'email.required'=> 'Masukkan isi kolom email',
        'name.required'=> 'Masukkan isi kolom nama',
        'password.required'=>'Masukkan isi kolom password',
        'status.required'=>'Masukkan pilih status',
        'dosen.required'=> 'Pilih Dosen pembimbingnya'
      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

      $data['email']= $request->email;
      $data['name']= $request->name;
      if($request->password){
        $data['password']=Hash::make($request->password); 
      }
      $data['status']=$request->status;
      $name=$request->dosen;
      $dosen_id=dosen::select('domen_id')->where('name','like','%'.$name.'%')->first()->domen_id;
      $data2['domen_id']=$dosen_id;
      $status= $request->status;
      laporan::where('npm',$id)->update($data2);
      
      User::where('npm',$id)->update($data);

      return redirect()->route('admin.mahasiswa');
   
    }
    public function update2(Request $request,$id){
      $validator= Validator::make($request->all(),[
        "email"=> "required|email",
        "name"=> "required",
        "password"=> "required",
        'status'=>"required",
      ],[
        'email.required'=> 'Masukkan isi kolom email',
        'name.required'=> 'Masukkan isi kolom nama',
        'password.required'=>'Masukkan isi kolom password',
        'status.required'=>'Masukkan pilih status'
      ]);
      if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

      $data['email']= $request->email;
      $data['name']= $request->name;
      if($request->password){
        $data['password']=Hash::make($request->password); 
      }
      $data['status']=$request->status;
      $status= $request->status;
      if($status== 'Dosen'){
        dosen::find($id)->update($data);
        return redirect()->route('admin.domen');
      }elseif($status == 'Mentor'){
        dosen::find($id)->update($data);
        return redirect()->route('admin.domen');
      }
     
    }
    
    // function to delete mahasiswa
    public function delete(Request $request,$id){
      $data=User::find($id);

      if($data){
        $data->delete();
      }

      return redirect()->route('admin.mahasiswa');
    }
    // function to delete dosen
    public function delete2(Request $request,$id){
      DB::table('domen')->where('domen_id',$id)->delete();


      return redirect()->route('admin.domen');
    }
}

