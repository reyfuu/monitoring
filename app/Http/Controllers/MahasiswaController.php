<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\comment;
use App\Models\laporan;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class MahasiswaController extends Controller
{
    public function proposal(){
        // $npm=FacadesSession::get('npm');
        // $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('type','Proposal')->exists();
        // $status= laporan::select('dokumen')->where('npm',$npm)->where('status','Finish')->exists();
        // if($dokumen){
        //     if($status){
        //         return view('layout.mhs.proposal.proposal3');
        //     }else{
        //         return view('layout.mhs.proposal.proposal2');
        //     }
        // }else{
            return view('layout.mhs.proposal.proposal');
        // }
     
    }
    public function proposal2(){
        // $npm=FacadesSession::get('npm');
        // $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('status','Finish')->exists();
        // if(!$dokumen){
            return view('layout.mhs.proposal.proposal2');
        // }else{
        //     return view('layout.mhs.proposal.proposal3');
        // }

    }
    public function proposal3(){
        return view('layout.mhs.proposal.proposal3');
    }
    public function laporan(){
        return view('layout.mhs.laporan.laporan');
    }
    public function laporan2(){
        // Get the start of the current week (Sunday)
        $npm=FacadesSession::get('npm');
        $tanggal_mulai= laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
        $startDate = Carbon::parse($tanggal_mulai);

        $tanggal_berakhir= laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
        
        $endDate = Carbon::parse($tanggal_berakhir);
        
        $currentMonth= $startDate->month;
        $endMonth= $endDate->month;

        // Loop through each month (February to July)
        for($currentMonth ;$currentMonth<=$endMonth;$currentMonth++) {
          
            while ($startDate<=$endDate) {
                $weekend = [
                  'start_date' => $startDate->startOfWeek()->format('d'),  // Extract only day
                  'start_month' => $startDate->startOfWeek()->format('F'),  // Extract only day
                  'end_date' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('d'),
                  'end_month' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('F'),
                ];
                $weekends[] = $weekend;

                $startDate = $startDate->addWeek();

        }

          // Loop through each week within the month
         
        }
        return view('layout.mhs.laporan.laporan2',compact('weekends'));
    }

    public function laporan3( String $startDate,String $endDate){
        return view('layout.mhs.laporan.laporan3',compact('startDate','endDate'));
    }   


    public function ta(){
        // $npm=FacadesSession::get('npm');
        // $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('type','Laporan')->first()->dokumen;
        // if($dokumen){
        //     return view('layout.mhs.ta.ta2');
        // }else{
            return view('layout.mhs.ta.ta');
        // }
    }
    public function ta2(){
        return view('layout.mhs.ta.ta2');
    }
    public function ta3(){
        return view('layout.mhs.ta.ta3');
    }
    public function store(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['judul']= $request->judul;
        $data['deskripsi']= $request->deskripsi;
        $data['status']='submit';
        $dokumen= $request->file('file');
        $filename=$dokumen->getClientOriginalName();
        $path='dokumen/'.$filename;
        $status=$request->status;
        $npm=FacadesSession::get('npm');
        Storage::disk('public')->put($path,file_get_contents($dokumen));
        $data['dokumen']=$filename;
        if($status== 'Proposal'){
            laporan::where('npm',$npm)->where('type',$status)->update($data);
            return redirect()->route('mhs.proposal2');
        }else{
            $laporan_id= IdGenerator::generate(
                ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
            $data['laporan_id']=$laporan_id;
            $data['tanggal_mulai']=laporan::select('tanggal_mulai')->
            where('npm',$npm)->where('type','Proposal')->first()->tanggal_mulai;
            $data['tanggal_berakhir']=laporan::select('tanggal_berakhir')->
            where('npm',$npm)->where('type','Proposal')->first()->tanggal_berakhir;
            $data['domen_id']=laporan::select('domen_id')->
            where('npm',$npm)->where('type','Proposal')->first()->domen_id;
            $data['type']='Laporan';
            $data['npm']=$npm;
            laporan::create($data);
            return redirect()->route('mhs.ta');
        }
    }
    public function update(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data['status']='revisi';
        $dokumen= $request->file('file');
        $filename=$dokumen->getClientOriginalName();
        $path='dokumen/'.$filename;
        $status=$request->status;
        $npm=FacadesSession::get('npm');
        Storage::disk('public')->put($path,file_get_contents($dokumen));
        $data['dokumen']=$filename;
        $comment_id= IdGenerator::generate(
            ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'CM']);
        $data2['comment_id']=$comment_id;
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $data2['domen_id']=$domen_id;
        $data2['npm']=$npm;
        $data2['tanggal']= new DateTime();
        $data2['isi']= $request->komentar;

        if($status== 'Proposal'){
            laporan::where('npm',$npm)->where('type',$status)->update($data);
            comment::create($data2);
            return redirect()->route('mhs.proposal2');
        }else{
 
            laporan::create($data);
            return redirect()->route('mhs.ta');
        }


       
    }
}
