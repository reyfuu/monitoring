<?php

namespace App\Http\Controllers;

use App\Models\dosen;
use App\Models\laporan;
use App\Models\laporan_harian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;

class DosenController extends Controller
{
    public function proposal(){
        $mahasiswa = user::all();
        $proposal= laporan::all();
        $domen_id= FacadesSession::get('domen_id');

        $combinedData=[];
        foreach($mahasiswa as $mhs){
            $laporan= $proposal->where('npm',$mhs->npm)->where('domen_id',$domen_id)->
            where('type','Proposal')->first();

            $combinedData[] = [
                'name' => $mhs->name,
                'email' => $mhs->email,
                'dokumen'=> $laporan ? $laporan->dokumen : '-',
            ];
        }

        return view('layout.dsn.dashboardp',compact('combinedData'));
    }
    public function proposal2(){
        return view('layout.dsn.proposal.proposal');
    }
    public function proposal3(){
        return view('layout.dsn.proposal.proposal2');
    }
    
    public function laporan(){
        $mahasiswa = user::all();
        $laporanHarian= laporan_harian::all();
        $domen_id= FacadesSession::get('domen_id');

        $combinedData=[];
        foreach($mahasiswa as $mhs){
 
            $laporan= $laporanHarian->where('npm',$mhs->npm)->where('domen_id',$domen_id);
            foreach($laporan as $l){
                $combinedData[] = [
                    'name' => $mhs->name,
                    'email' => $mhs->email,
                    'has_laporan'=> !is_null($laporan),
                    'isi'=> $l->isi ? $l->isi : '-',
                ];
            }

        }

        return view('layout.dsn.dashboardl',compact('combinedData'));
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
            where('type','Laporan')->first();

            $combinedData[] = [
                'name' => $mhs->name,
                'email' => $mhs->email,
                'dokumen'=> $laporan ? $laporan->dokumen : '-',
            ];
        }
        return view('layout.dsn.dashboardt',compact('combinedData'));
    }
    public function ta2(){
        return view('layout.dsn.ta.ta');
    }
    public function ta3(){
        return view('layout.dsn.ta.ta2');
    }
}
