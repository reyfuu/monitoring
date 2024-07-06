<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\laporan;
use App\Models\laporan_harian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
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
                    'name' => $mhs->name,
                    'email' => $mhs->email,
                    'proposal'=> $laporan ? $laporan->type : '-',
                    'dokumen'=> $laporan ? $laporan->deskripsi : 'belum submit',
                    ];



        }

        return view('layout.dsn.dashboardp',compact('combinedData'));
    }
    public function proposal2(Request $request){
        $id=$request->id;
        $proposal = laporan::where('laporan_id',$id)->first()->dokumen;
        return view('layout.dsn.proposal.proposal');
    }
    public function proposal3(){
        return view('layout.dsn.proposal.proposal2');
    }
    
    public function laporan(){
        $mahasiswa = user::all();
        $laporanHarian= laporan_harian::all();
        $domen_id= FacadesSession::get('domen_id');
        $totalWeek= $laporanHarian->last();
        $totalWeek= $totalWeek ? $totalWeek->minggu : '-';
        $combinedData=[];
        foreach($mahasiswa as $mhs){
 
            $laporan= $laporanHarian->where('npm',$mhs->npm)->where('domen_id',$domen_id);
            $week = $laporanHarian->where('npm',$mhs->npm)->where('domen_id',$domen_id)->last();
            $week= $week ? $week->minggu : '-';
            $i= 1;
            foreach($laporan as $l){
                if($week != $l->minggu ){
                    $combinedData[$i][] = [
                        'name' => $mhs->name,
                        'email' => $mhs->email,
                        'has_laporan'=> !is_null($laporan),
                        'isi'=> $l->isi ? $l->isi : '-',
                        'minggu'=> $l->minggu,
                    ];
    
                }else{
                    $combinedData[$week][] = [
                        'name' => $mhs->name,
                        'email' => $mhs->email,
                        'has_laporan'=> !is_null($laporan),
                        'isi'=> $l->isi ? $l->isi : '-',
                        'minggu'=> $l->minggu,
                    ];
                    $i++;
                }


            }
    
        }

        return view('layout.dsn.dashboardl',compact('combinedData','week'));
    }
    public function laporan2(){

        return view('layout.dsn.laporan.laporan');
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
        $comment = $request->comment;
        $laporan_id= $request->laporan_id;
       
        $domen_id= FacadesSession::get('domen_id');
        
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
}
