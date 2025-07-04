<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\comment;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\laporan_harian;
use App\Models\laporan_mingguan;
use App\Models\User;
use App\Models\notifikasi;
use App\Models\evaluasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DosenController extends Controller
{
    public function markAsRead($id){
        $data['is_read']= true;
        $id2= notifikasi::where('notifikasi_id',$id)->first()->npm;
        $status= notifikasi::where('notifikasi_id',$id)->first()->type;
        if($status == 'BimbinganP'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('dmn/bimbingan/'.$id2);
        }elseif($status == 'BimbinganT'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('dmn/bimbingan2/'.$id2);
        }elseif($status== 'Proposal'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->route('dmn.proposal');
        }elseif($status == 'Tugas Akhir'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->route('dmn.ta');
        }

        notifikasi::where('notifikasi_id',$id)->update($data);
        return redirect()->to('dmn/chat/'.$id2);
    }
    public function chat(User $user){
        $domen_id= session('domen_id');
        $LoggedUserInfo= dosen::find($domen_id);
        $siswa= laporan::distinct()->join('mahasiswa','mahasiswa.npm','=','laporan.npm')->
        where('laporan.domen_id',$domen_id)->get(['mahasiswa.npm as npm','mahasiswa.name as name']);

       return view('layout.chat',compact('siswa','LoggedUserInfo'));

    }
    public function getchat($id){
        $domen_id= session('domen_id');
        $LoggedUserInfo= dosen::find($domen_id);
        $siswa= laporan::distinct()->join('mahasiswa','mahasiswa.npm','=','laporan.npm')->
        where('laporan.domen_id',$domen_id)->get(['mahasiswa.npm as npm','mahasiswa.name as name']);
        $name= user::where('npm',$id)->first()->name;
     
       return view('layout.chat2',compact('siswa','name','id'));

    }
    public function fetchMessages($npm){
        $chat= comment::where('npm',$npm)->orderBy('created_at','asc')->get();

        return response()->json($chat);
    }
    public function dashboard(){

        $domen_id= session('domen_id');
        // $bimbingan= bimbingan::where('domen_id',$domen_id)->get(['bimbingan.status as status']);
        $bimbingan = laporan::where('domen_id',$domen_id)->where('type','Proposal')->get();
        $countMahasiswa= count($bimbingan);
        $bimbingan2= bimbingan::where('status','submit')->get();
        $countSubmit= count($bimbingan);
        $dt_mahasiswa = User::wherehas('bimbingan',function($query){
            $domen_id= session('domen_id');
            $query->where('domen_id',$domen_id)->where('type','Tugas Akhir');

        })->withCount('bimbingan')->having('bimbingan_count','>=',14)->get();
        $dt_mahasiswa= count($dt_mahasiswa);
        $submit= 'submit';

        $coba = laporan::selectRaw("case when status= 'submit' then 'mahasiswa submit' 
        when status= 'Revisi' then 'mahasiswa revisi dan sudah dilihat'
        when status= 'Finish' then 'mahasiswa selesai'
        when status= 'belum dilihat' then 'mahasiswa revisi tapi belum dilihat'
        else 'mahasiswa belum submit'  end as status,count(status) as count ")
        ->where('domen_id',$domen_id)->where('type','Proposal')->groupBy('status')->get();
        $tugasAkhir= laporan::selectRaw("case when status= 'submit' then 'mahasiswa submit' 
        when status= 'Revisi' then 'mahasiswa revisi dan sudah dilihat'
        when status= 'Finish' then 'mahasiswa selesai'
        when status= 'belum dilihat' then 'mahasiswa revisi tapi belum dilihat'
        else 'mahasiswa belum submit'  end as status,count(status) as count ")
        ->where('domen_id',$domen_id)->where('type','Tugas Akhir')->groupBy('status')->get();


        $mentor = dosen::select('status')->where('domen_id',$domen_id)->get();
        return view('layout.dsn.dbimbingan', compact('dt_mahasiswa','countSubmit','countMahasiswa',
        'coba','tugasAkhir'));
    }
    public function setujup($id){

        return view('layout.dsn.setujup',compact('id'));
    }
    public function setujut($id){
        return view('layout.dsn.setujut',compact('id'));
    }
    public function detailb($id){
        
        $data= Bimbingan::where('bimbingan_id',$id)->get();
        $domen_id= session('domen_id');
        $npm = Bimbingan::where('bimbingan_id',$id)->first()->npm;
 

        return view('layout.dsn.detailb',compact('data'));
    }
    public function dashboardm(){
        $domen_id = session('domen_id');
        $mahasiswa= laporan_mingguan::where('domen_id',$domen_id)->get();
        $countMahasiswa= count($mahasiswa);
        $LaporanMingguan= laporan_mingguan::selectRaw("case 
        when status= 'menunggu persetujuan mentor' then 'mahasiswa submit'
        when status= 'revisi' then 'mahasiswa revisi'
        when status= 'disetujui' then 'mahasiswa disetujui'
        else 'mahasiswa belum submit' end as status, count(status) as count")
        ->where('domen_id',$domen_id)->groupBy('status')->get();

        return view('layout.dsn.dashboardm',compact('countMahasiswa','LaporanMingguan'));
    }
    public function bimbingan($id){
        $data= Bimbingan::where('npm','like','%'.$id.'%')->where('Type','Proposal')->get();
        return view('layout.dsn.bimbingan',compact('data'));
    } 
    public function edit($id){
        $data= bimbingan::select('bimbingan.bimbingan_id as bimbingan','bimbingan.topik as topik',
        'bimbingan.tanggal as tanggal','bimbingan.isi as isi')->
        where('bimbingan.bimbingan_id','=',$id)->get();
        $domen_id= session('domen_id');
      
        return view('layout.dsn.editb', compact('data'));
    }
    public function dbimbingan(){
        $domen_id= session('domen_id');


        $bimbingan= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen','domen.domen_id','=','laporan.domen_id')
        ->join('bimbingan','bimbingan.npm','=','laporan.npm' )
        ->where('laporan.type','Proposal')->where('domen.domen_id','=',$domen_id)
        ->distinct('mahasiswa.npm')  
        ->groupBy('mahasiswa.npm', 'laporan.status', 'mahasiswa.name', 'laporan.judul', 'laporan.laporan_id', 'domen.domen_id')
        ->get(['laporan.status as status2','mahasiswa.name as nama',
        'laporan.judul as topik','laporan.laporan_id as id','laporan.type as type',
        DB::raw('SUM(CASE WHEN bimbingan.status = "Finish" AND bimbingan.type="Proposal" THEN 1 ELSE 0 END) as bimbingan_count'),'mahasiswa.npm as npm'
        ]);


        $isi= Bimbingan::where('domen_id',$domen_id)->get();
    

        
        return view('layout.dsn.dashboard',compact('bimbingan'));
    }
    public function bimbingan2($id){
        $data= Bimbingan::where('npm','like','%'.$id.'%')->where('Type','Tugas Akhir')->get();
        return view('layout.dsn.bimbingan2',compact('data'));
    }
    public function dbimbingan2(){
        $domen_id= session('domen_id');

        $bimbingan= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen','domen.domen_id','=','laporan.domen_id')
        ->join('bimbingan','bimbingan.npm','=','laporan.npm' )
        ->where('laporan.type','Tugas Akhir')->where('domen.domen_id','=',$domen_id)
        ->distinct('mahasiswa.npm')  
        ->groupBy('mahasiswa.npm', 'laporan.status', 'mahasiswa.name', 'laporan.judul', 'laporan.laporan_id', 'domen.domen_id')
        ->get(['laporan.status as status2','mahasiswa.name as nama',
        'laporan.judul as topik','laporan.laporan_id as id','laporan.type as type',
        DB::raw('SUM(CASE WHEN bimbingan.status = "Finish" AND bimbingan.type="Tugas Akhir" THEN 1 ELSE 0 END) as bimbingan_count'),'mahasiswa.npm as npm'
        ]);


        $isi= Bimbingan::where('domen_id',$domen_id)->get();
    
        return view('layout.dsn.dashboard2',compact('bimbingan'));
    }
    public function detailb2($id){
        $data= Bimbingan::where('bimbingan_id',$id)->get();
        $domen_id= session('domen_id');
    
        $npm = Bimbingan::where('bimbingan_id',$id)->first()->npm;
        $bimbingan= comment::where('domen_id',$domen_id)->where('npm',$npm)->where('Type','Bimbingant')->get();
        return view('layout.dsn.detailb2',compact('data','bimbingan'));
    }
    public function edit2($id){
        $data= bimbingan::select('bimbingan.bimbingan_id as bimbingan','bimbingan.topik as topik',
        'bimbingan.tanggal as tanggal','bimbingan.isi as isi')->
        where('bimbingan.bimbingan_id','=',$id)->get();
        $domen_id= session('domen_id');
      
        return view('layout.dsn.editb2', compact('data'));
    }
    
    
    public function proposal(){
   
        $domen_id= session('domen_id');
    
        $eval = evaluasi::where('domen_id',$domen_id)->where('type','Proposal')->get();
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Proposal%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id','laporan.status_domen','mahasiswa.npm as npm']);
  
        return view('layout.dsn.dashboardp',compact('data','eval'));
    }
    public function rekapp($id){
        $domen_id = session('domen_id');
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Proposal%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')->where('laporan.npm',$id)
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id','laporan.status_domen','mahasiswa.npm as npm']);
        
        $bimbingan= comment::where('domen_id',$domen_id)->where('npm',$id)->where('type','Proposal')
        ->get();
        return view('layout.dsn.detailp',compact('data','bimbingan'));
    }
    public function proposal2(Request $request){
        $id=$request->id;
        $proposal = laporan::where('laporan_id',$id)->first()->dokumen;
        return view('layout.dsn.proposal.proposal',compact('proposal','id'));
    }
    public function proposal3(){
        return view('layout.dsn.proposal.proposal2');
    }
    
    public function laporan(){
        $mahasiswa= laporan_mingguan::join('mahasiswa','mahasiswa.npm','=','laporan_mingguan.npm')
        ->get(['laporan_mingguan.laporan_mingguan_id as id',
        'mahasiswa.name as name','laporan_mingguan.status as status2','laporan_mingguan.isi as isi']);
        return view('layout.dsn.dashboardla',compact('mahasiswa'));

    }
    public function laporan2(Request $request){
        $npm= $request->npm;
        $week= $request->week;
        $laporan_harian= laporan_harian::all();
        $laporan= $laporan_harian->where('minggu',$week)->where('npm',$npm);
        $laporan_mingguan= laporan_mingguan::where('npm',$npm)->where('week',$week)->first();
        $days= [];

    
            foreach($laporan as $l){
                $tanggal= $l->tanggal;
                $tanggal= Carbon::parse($tanggal);
                $days[]= 
                [
                    'date'=> $tanggal->translatedFormat('l d F Y'),
                    'isi'=> $l ? $l->isi : '-',
    
                ];
            
            }
    
        return view('layout.dsn.laporan.laporan',compact('days','laporan_mingguan'));
    }
    public function ta(){
        $domen_id= FacadesSession::get('domen_id');
    
        $eval = evaluasi::where('domen_id',$domen_id)->where('type','Tugas Akhir')->get();
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Tugas Akhir%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id','mahasiswa.npm as npm']);

        return view('layout.dsn.dashboardt',compact('data','eval'));
    }
    public function rekapt($id){
        $domen_id= FacadesSession::get('domen_id');
    
       
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Tugas Akhir%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')->where('laporan.npm',$id)
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id','mahasiswa.npm as npm']);

        $bimbingan= comment::where('domen_id',$domen_id)->where('npm',$id)->where('type','Tugas Akhir')
        ->get();

        return view('layout.dsn.detailt',compact('data','bimbingan'));
    }
    public function ta2(Request $request){
        $id= $request->id;
        $ta= laporan::where('laporan_id',$id)->first()->dokumen;

        return view('layout.dsn.ta.ta',compact('ta','id'));
    }

    public function viewTa($id){
        return response()->file(public_path('/storage/dokumen/'.$id,['Content-Type'=>'application/pdf']));
    }
    public function ta3(){
        return view('layout.dsn.ta.ta2');
    }
    public function setujubp($id){
        $data= Bimbingan::where('bimbingan_id',$id)->get();
        return view('layout.dsn.setujubp',compact('data','id'));
    }
    public function setujubt($id){
        $data= Bimbingan::where('bimbingan_id',$id)->get();
        return view('layout.dsn.setujubt',compact('data','id'));
    }
    public function store(Request $request){
        $request->validate([
            'status'=>'required',
            'comment'=>'required',
        ],[
            'status.required'=>'Masukkan status diisi',
            'comment.required'=>'Masukkan komentar diisi',
        ]
    );
        $status= $request->status;
        $laporan_id= $request->laporan_id;

        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan::where('laporan_id','like','%'.$laporan_id.'%')->first()->npm;
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comment', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
        $data['domen_id']= FacadesSession::get('domen_id');
        $data['isi']= $request->comment;
        comment::create($data);
        
        if($status== 'Revisi'){
            $status2= 'perlu direvisi';
            laporan::where('laporan_id',$laporan_id)->update(['status'=>$status2]);
            return redirect()->route('dmn.ta');
        }else{
            $status2= 'selesai';
            laporan::where('laporan_id',$laporan_id)->update(['status'=>$status2]);
            return redirect()->route('dmn.ta');
        }

    }

    public function store2(Request $request){

        $request->validate([
            'status'=> 'required',
            'isi'=> 'required'
        ],[
            'status.required'=> 'Masukkan status diisi',
            'isi.required'=> 'Masukkan komentar diisi'
        ]);
        $status = $request->status;

        $laporan_id= $request->laporan_id;

        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan::where('laporan_id','like','%'.$laporan_id.'%')->first()->npm;
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comment', 'field' => 'comment_id', 'length' => 10, 'prefix' => 'CM']);
        $data['domen_id']= FacadesSession::get('domen_id');
        $data['isi']= $request->comment;
        $data['type']= 'Proposal';
        comment::create($data);

        if($status== 'Revisi'){
            $status2= 'perlu direvisi';
            laporan::where('laporan_id',$laporan_id)->update(['status'=>$status2]);
            return redirect()->route('dmn.proposal');
        }else{
            $status2= 'selesai';
            laporan::where('laporan_id',$laporan_id)->update(['status'=>$status2]);
            return redirect()->route('dmn.proposal');
        }
    }
    public function message(Request $request){
        $domen_id= session('domen_id');
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comments', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
        $data['message']= $request->userMessages;
        $data['receiver']='mahasiswa';
        $data['sender']='domen';
        $data['domen_id']=$domen_id;
        $data['npm']=$request->npm;
        $data['created_at']=now();
        comment::create($data);
        $notifikasi_id= notifikasi::where('sender','dosen')->where
        ('npm',$data['npm'])->where('domen_id',$domen_id)->where('type','chat')->first();
        if($notifikasi_id){
            $data3['is_read']=false;
            $data3['type']='chat';
            notifikasi::where('notifikasi_id',$notifikasi_id)->update($data3);
            return redirect()->route('dmn.chat'); 
        }else{
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $request->npm;
            $data2['domen_id']=$domen_id;
            $data2['sender']= 'dosen';
            $data2['receiver']= 'mahasiswa';
            $name= dosen::where('domen_id',$domen_id)->first()->name;
            $data2['message']='Anda memiliki pesan baru dari '. $name;
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='chat';
            Notifikasi::create($data2);
            return redirect()->route('dmn.chat'); 
            }
        
    }
    public function update(Request $request){
        $request->validate([
            'status'=>'required',
            'comment'=>'required',
        ],[
            'status'=>'Masukkan status diisi',
            'comment'=>'Masukkan komentar diisi',
        ]);
        $status= $request->status;
        $id= $request->id;

        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan_mingguan::where('laporan_mingguan_id','like','%'.$id.'%')->first()->npm;
        $data['comment_id'] = IdGenerator::generate(
            ['table'=> 'comment','field'=> 'comment_id','length'=>5,'prefix'=>'CM']);
        $data['domen_id']= FacadesSession::get('domen_id');
        $data['isi']= $request->comment;
        comment::create($data);
        if($status== 'Revisi'){
            $status2 = 'perlu direvisi';
            laporan_mingguan::find($id)->update(['status'=>$status2]);

            return redirect()->route('dmn.laporan');
        }else{
            $status2 = 'selesai';
            laporan_mingguan::find($id)->update(['status'=>$status2]);
            return redirect()->route('dmn.laporan');
        }
    }
    public function update2(Request $request){
        $request->validate([
            'status_domen'=>'required',
            'eval'=>'required',
        ],[
            'status_domen'=>'Masukkan diisi status mahasiswa',
            'eval.required'=> ' Masukkan komentar '
        ]);
   

       
         
   
        
        $id= $request->id;
        $npm = bimbingan::select('npm')->where('bimbingan_id',$id)->first()->npm;
  
        $data2['npm']= $npm;
        $data2['created_at']=now();
        $data2['sender']='domen';
        $data2['receiver']='mahasiswa';
        $type= bimbingan::where('bimbingan_id',$id)->first()->type;
        $data2['comment_id']= IdGenerator::generate(
            ['table' => 'comments', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
        $data2['domen_id']= session('domen_id');
        $data2['message']= $request->eval;
        $data['komentar']=$request->eval;
        if($type == 'Proposal'){
            $data2['type']= 'Bimbinganp';
            $data3['type']= 'BimbinganP';
        }else{
            $data2['type']= 'Bimbingant';
            $data3['type']= 'BimbinganT';
        }
        $data['status_domen']=$request->status_domen;

        if($data['status_domen'] == 'disetujui' && $type=='Proposal'){  
            $data['status']= 'Finish';
            $data3['message']='Bimbingan Proposal sudah disetujui oleh dosen pembimbing';
        }elseif($data['status_domen'] !== 'disetujui' && $type=='Proposal'){
            $data['status']= 'sudah dilihat';
            $data3['message']='Bimbingan Proposal telah direvisi oleh dosen pembimbing ';
        }elseif($data['status_domen'] == 'disetujui' && $type=='Tugas Akhir'){
            $data['status']= 'Finish';
            $data3['message']='Bimbingan Tugas Akhir sudah disetujui oleh dosen pembimbing';
        }elseif($data['status_domen'] !== 'disetujui' && $type=='Tugas Akhir'){
            $data['status']= 'sudah dilihat';
            $data3['message']='Bimbingan Tugas Akhir telah direvisi oleh dosen pembimbing';
        }

        if($data2 == ''){
            return redirect()->to($id->url);
        }else{

            Bimbingan::find($id)->update($data);

            if($data2['type'] == 'Bimbinganp'){
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $npm;
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
                
                
                notifikasi::create($data3);
                return redirect()->route('dmn.bimbingan',['id'=>$npm]);
            }else{
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $npm;
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
                
                
                notifikasi::create($data3);
                return redirect()->route('dmn.bimbingan2',['id'=>$npm]);
            }
        }


    }
    public function update3(Request $request){

     

        $request->validate([
            'eval'=>'required',
        ],[
            'eval.required'=>'Masukkan isi Komentar',
        ]);


        $data['statuscheck']=$request->statuscheck;
        $id= $request->laporan_id;
        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan::where('laporan_id','like','%'.$id.'%')->first()->npm;
        $data['type']= laporan::where('laporan_id','like','%'.$id.'%')->first()->type;
        $data['eval_id'] = IdGenerator::generate(
            ['table' => 'evaluasi', 'field' => 'eval_id', 'length' => 5, 'prefix' => 'EV']);
        $data['domen_id']= session('domen_id');
        $data['isi']= $request->eval;
        evaluasi::create($data);

        $data2['status_domen']=$request->status_domen;
        $status= $request->status;
        if($data2['status_domen'] == 'disetujui' && $status == 'Proposal'){  
            $data2['status']= 'Finish';
            $data3['message']='Proposal sudah disetujui oleh dosen pembimbing';
        }elseif($data2['status_domen'] == 'direvisi' && $status =='Proposal'){
            $data2['status']= 'sudah dilihat';
            $data3['message']= 'Proposal telah direvisi oleh dosen pembimbing';
        }elseif($data2['status_domen'] == 'disetujui' && $status == 'Tugas Akhir'){
            $data2['status']= 'Finish';
            $data3['message']= 'Tugas Akhir telah disetujui oleh dosen pembimbing';
        }elseif($data2['status_domen'] == 'direvisi' && $status == 'Tugas Akhir'){
            $data2['status']= 'sudah dilihat';
            $data3['message']= 'Tugas Akhir telah direvisi oleh dosen pembimbing';
        }

       
        laporan::where('laporan_id',$id)->update($data2);
        if($status == 'Proposal'){
            if($data2['status_domen'] == 'disetujui'){  
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $data['npm'];
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
         
                $data3['type']= 'Proposal';
                notifikasi::create($data3);
            }else{
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $data['npm'];
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
         
                $data3['type']= 'Proposal';
            
                notifikasi::create($data3);
            }

            return redirect()->route('dmn.proposal');
        }else{
            if($data2['status_domen'] == 'disetujui'){  
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $data['npm'];
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
                $data3['type']= "Tugas Akhir";
        
                notifikasi::create($data3);
            }else{
                $data3['notifikasi_id']= IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data3['npm']= $data['npm'];
                $data3['domen_id']=session('domen_id');
                $data3['sender']='dosen';
                $data3['receiver']='mahasiswa';
                $data3['created_at']=now();
                $data3['is_read']= false;
                $data3['type']= "Tugas Akhir";
 
                notifikasi::create($data3);
            }
            return redirect()->route('dmn.ta');
        }
   


    }
    public function update4(Request $request){


            $data['topik']= $request->topik;
            $data['isi']= $request->deskripsi;
            $data['tanggal']= $request->tanggal;
            $data2['komentar']= $request->komentar;
            $bimbingan_id= $request->id;
            $type= bimbingan::where('bimbingan_id',$bimbingan_id)->first()->type;
            bimbingan::find($bimbingan_id)->update($data);
            if($type == 'Proposal'){
                return redirect()->route('dmn.dbimbingan');
            }else{
                return redirect()->route('dmn.dbimbingan2');
            }
          
    }
}
