<?php

namespace App\Http\Controllers;

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
    public function proposal(){
        $mahasiswa = user::all();
        $proposal= laporan::all();
        $domen_id= FacadesSession::get('domen_id');
     

        $combinedData=[];
        foreach($mahasiswa as $mhs){
            // $date= laporan::where('npm',$mhs->npm)->where('domen_id',$domen_id)->first()->tanggal_mulai;
            // dd($date);

            $laporan= $proposal->where('npm',$mhs->npm)->where('domen_id',$domen_id)->
            where('type','Proposal')->sortDesc()->first();

                $combinedData[] = [
                    'proposal_id'  =>  $laporan ? $laporan->laporan_id : '0' ,
                    'name' => $mhs->name,
                    'email' => $mhs->email,
                    'proposal'=> $laporan ? $laporan->type : '-',
                    'has_proposal'=> !is_null($laporan),
                    'dokumen'=> $laporan ? $laporan->status : 'belum submit',
                    ];

        }

        return view('layout.dsn.dashboardp',compact('combinedData'));
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
        $mahasiswa = user::all();
        $laporanMingguan= laporan_mingguan::all();
        $domen_id= FacadesSession::get('domen_id');
        $combinedData=[];
        foreach($mahasiswa as $mhs){
            $proposal= $laporanMingguan->where('npm',$mhs->npm)->where('domen_id',$domen_id);
            
            foreach($proposal as $p){
                    $combinedData[] = [
                        'name' => $mhs->name,
                        'email' => $mhs->email,
                        'has_laporan'=> !is_null($proposal),
                        'status'=> $p->status ? $p->status : '-',
                        'npm'=> $p->npm,
                        'week'=> $p->week,
                    ];
            }
    
        }

        return view('layout.dsn.dashboardl',compact('combinedData'));
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
        $mahasiswa = user::all();
        $ta= laporan::all();
        $domen_id= FacadesSession::get('domen_id');

        $combinedData=[];
        foreach($mahasiswa as $mhs){
            $laporan= $ta->where('npm',$mhs->npm)->where('domen_id',$domen_id)->
            where('type','Laporan')->sortDesc()->first();
    
            $combinedData[] = [
                'ta_id'  =>  $laporan->laporan_id ,
                'name' => $mhs->name,
                'email' => $mhs->email,
                'ta'=> $laporan ? $laporan->type : '-',
                'has_ta'=> !is_null($laporan),
                'dokumen'=> $laporan ? $laporan->status : 'belum submit',
            ];
        }
        return view('layout.dsn.dashboardt',compact('combinedData'));
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
}
