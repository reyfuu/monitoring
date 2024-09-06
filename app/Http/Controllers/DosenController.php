<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\comment;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\laporan_harian;
use App\Models\laporan_mingguan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Carbon\Carbon;

class DosenController extends Controller
{
    
    public function dashboard(){

        $domen_id= session('domen_id');
        // $bimbingan= bimbingan::where('domen_id',$domen_id)->get(['bimbingan.status as status']);
        $bimbingan = laporan::where('domen_id',$domen_id)->where('type','Proposal')->get();
        $countMahasiswa= count($bimbingan);
        $bimbingan2= bimbingan::where('status','submit')->get();
        $countSubmit= count($bimbingan);
        $dt_mahasiswa = User::join('bimbingan', 'mahasiswa.npm', '=', 'bimbingan.npm')
        ->where('bimbingan.domen_id', '=', $domen_id)
        ->selectRaw('mahasiswa.npm, COUNT(mahasiswa.npm) as count_npm')
        ->groupBy('mahasiswa.npm')
        ->get();
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
        $LaporanMingguan= laporan_mingguan::selectRaw("case 
        when status= 'menunggu persetujuan mentor' then 'mahasiswa submit'
        when status= 'revisi' then 'mahasiswa revisi'
        when status= 'disetujui' then 'mahasiswa disetujui' end as status, count(status) as count")
        ->where('domen_id',$domen_id)->groupBy('status')->get();

        $i=0;
            foreach ($dt_mahasiswa as $d){
                if($d->count_npm >=14){
                    $i+=1;
                }
            }
        $mentor = dosen::select('status')->where('domen_id',$domen_id)->get();
        return view('layout.dsn.dbimbingan', compact('i','countSubmit','countMahasiswa',
        'coba','tugasAkhir','LaporanMingguan','mentor'));
    }
    public function bimbingan($id){
        $data= Bimbingan::where('npm','like','%'.$id.'%')->get();

        return view('layout.dsn.bimbingan',compact('data'));
    } 
    public function dbimbingan(){
        $domen_id= FacadesSession::get('domen_id');


        $bimbingan= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen','domen.domen_id','=','laporan.domen_id')
        ->where('type','Proposal')->where('domen.domen_id','=',$domen_id)
        ->get(['mahasiswa.status as status2','mahasiswa.name as nama',
        'laporan.judul as topik','laporan.laporan_id as id',
        'mahasiswa.npm as npm'
        ]);
        $isi= Bimbingan::where('domen_id',$domen_id)->get();
    

        
       
        return view('layout.dsn.dashboard',compact('bimbingan'));
    }
    public function proposal(){
   
        $domen_id= session('domen_id');
    
       
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Proposal%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id','laporan.status_domen']);
        // dd($data);
        return view('layout.dsn.dashboardp',compact('data'));
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
    
       
        $data= laporan::join('mahasiswa','mahasiswa.npm','=','laporan.npm')
        ->join('domen', 'domen.domen_id','=','laporan.domen_id')->where('laporan.type','like','%Tugas Akhir%')
        ->where('laporan.domen_id','like','%'.$domen_id.'%')
        ->get(['mahasiswa.name as mahasiswa','laporan.judul as judul','laporan.status',
        'laporan.dokumen as dokumen','laporan.laporan_id']);

        return view('layout.dsn.dashboardt',compact('data'));
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
    public function store(Request $request){
        $status= $request->status;
        $laporan_id= $request->laporan_id;

        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan::where('laporan_id','like','%'.$laporan_id.'%')->first()->npm;
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comment', 'field' => 'comment_id', 'length' => 10, 'prefix' => 'CM']);
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
    public function update(Request $request){
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
        $data['status']=$request->status;

        $id= $request->id_bimbingan;

        Bimbingan::find($id)->update($data);
        return redirect()->route('dmn.dashboard');

    }
    public function update3(Request $request){
        $data['status']=$request->status;
        $id= $request->laporan_id;
        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= laporan::where('laporan_id','like','%'.$id.'%')->first()->npm;
        $data['type']= laporan::where('laporan_id','like','%'.$id.'%')->first()->type;
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comment', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
        $data['domen_id']= FacadesSession::get('domen_id');
        $data['notifikasi']= 'sudah acc';
        $data['isi']= $request->comment;
        comment::create($data);

        $data2['status_domen']=$request->status_domen;
        if($data2['status_domen'] == 'disetujui'){
            $data2['status']= 'Finish';
        }else{
            $data2['status']= 'belum dilihat';
        }

        $status= $request->status;
        laporan::where('laporan_id',$id)->update($data2);
        if($status == 'Proposal'){
            return redirect()->route('dmn.proposal');
        }else{
            return redirect()->route('dmn.ta');
        }


    }
}
