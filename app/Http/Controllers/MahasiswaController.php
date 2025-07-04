<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\Bimbingan;
use App\Models\comment;
use App\Models\dosen;
use App\Models\laporan;
use App\Models\laporan_harian;
use App\Models\laporan_mingguan;
use App\Models\syarat;
use App\Models\evaluasi;
use App\Models\notifikasi;
use DB;
use App\Models\User;
use Barryvdh\Debugbar\Facade;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Session as FacadesSession;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class MahasiswaController extends Controller
{     
    public function markAsRead($id){
        $data['is_read']= true;
        $status = notifikasi::where('notifikasi_id',$id)->first()->type;
        if($status == 'BimbinganP'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('mhs/bimbingan');
        }elseif($status == 'BimbinganT'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('mhs/bimbingan2');
        }elseif($status == 'Proposal'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('mhs/proposal');
        }elseif($status == 'Tugas Akhir'){
            notifikasi::where('notifikasi_id',$id)->update($data);
            return redirect()->to('mhs/ta');
        }

        notifikasi::where('notifikasi_id',$id)->update($data);
        return redirect()->to('mhs/chat/');
    }
    public function fetchMessages(){
            $npm= session('npm');
            $chat= comment::where('npm',$npm)->orderBy('created_at','asc')->get();
            return response()->json($chat);
        }
    public function message(Request $request){
            $npm= session('npm');
            $data['comment_id'] = IdGenerator::generate(
                ['table' => 'comments', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
            $data['message']= $request->userMessages;
            $data['receiver']='domen';
            $data['sender']='mahasiswa';
            $data['domen_id']=$request->domen_id;
            $data['npm']=$npm;
            $data['created_at']=now();
            comment::create($data);
            $notifikasi_id= notifikasi::where('sender','mahasiswa')->where('npm',$npm)->where('type','chat')
            ->first();

            if($notifikasi_id ){
                $data3['is_read']= false;
                $data3['type']='chat';
                notifikasi::where('notifikasi_id',$notifikasi_id)->update($data3);

                return redirect()->route('mhs.chat'); 
              
            }else{
                $data2['notifikasi_id'] = IdGenerator::generate(
                    ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
                $data2['npm']= $npm;
                $data2['domen_id']=$request->domen_id;
                $data2['sender']= 'mahasiswa';
                $data2['receiver']= 'dosen';
                $name= user::where('npm',$npm)->first()->name;
                $data2['message']='Anda memiliki pesan baru dari '. $name;
                $data2['created_at']=now();
                $data2['is_read']=false;
                $data2['type']='chat';
                Notifikasi::create($data2);
                return redirect()->route('mhs.chat'); 
            }
            
          
        }
    public function home(){
        $npm= session('npm');
        $bimbingan=Bimbingan::where('npm','like','%'.$npm.'%')
        ->where('status_domen','disetujui')->get();
        $count= count($bimbingan);
        $judul= laporan::selectRaw(
            'CASE 
                WHEN type = "Tugas Akhir" AND status = "Finish" THEN judul
                WHEN type = "Proposal" AND status != "Finish" THEN judul
                WHEN type = "Tugas Akhir" AND status != "Finish" THEN judul
                ELSE NULL
            END as judul'
        )->where('npm',$npm)->get();
        
     
       
  
        return view('layout.mhs.dashboard',compact('npm','count','judul'));
    }

    public function chat(){
        $npm=session('npm');
        $name= laporan::distinct()->join('domen','domen.domen_id','=','laporan.domen_id')->
        where('laporan.npm',$npm)->get('domen.name as name');
       $id = laporan::where('npm',$npm)->first()->domen_id;
        return view('layout.mhs.chat',compact('name','id'));
    }
    public function magang(){
        $npm= session('npm');
        $bimbingan = laporan_mingguan::where('npm',$npm)->where('status','disetujui')->get();
        $count= count($bimbingan);

        return view('layout.mhs.dashboard2',compact('count'));
    }
    // function show proposal when  submit
    public function proposal(){
        $npm= session('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Proposal')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Proposal')->
        where('status_domen','disetujui')->get();
        $bimbingan = count($bimbingan);
  
      
  
        if(!$dokumen->dokumen){
            $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            return view('layout.mhs.proposal.proposal',compact('eval'));
        }

            if($dokumen->status_domen == 'disetujui'){
    
                if($bimbingan >= 5){
                    return view('layout.mhs.proposal.proposal3');
                }else{
                    $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();
    
             
                    return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
                }
 
            }else{
                $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();

                return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
            }
       
        }
   
    
    public function viewProposal($id){
        return response()->file(public_path('storage/dokumen/'.$id,['Content-Type'=>'application/pdf']));
    }

    
    public function editProposal(Request $request,$id){
        $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.laporan_id',$id)->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi'
                ,'laporan.type as type']);
        return view('layout.mhs.proposal.edit',compact('proposal'));
    }
    public function editTa(Request $request,$id){
        $Ta= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.laporan_id',$id)->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi'
                ,'laporan.type as type']);
        return view('layout.mhs.ta.edit',compact('Ta'));
    }
    // function show proposal when revisi
    public function proposal2(){
        $npm= session('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Proposal')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Proposal')->
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);

        if(!$dokumen->dokumen){
            return view('layout.mhs.proposal.proposal');
        }
        if($dokumen->status == "submit" ){
            $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->get();
        
            return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
        }
        elseif($dokumen->status == "Revisi" ){
            $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
           
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();
 
            return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
        }elseif($dokumen->status == 'disetujui'){
            if($bimbingan >= 5){
                return view('layout.mhs.proposal.proposal3');
            }else{
                $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();

                return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
            }
        }else{
            $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();
 
            return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
        }

    }
    public function upload(){
        return view('layout.mhs.proposal.upload');
    }
    // function show proposal when finish
    public function proposal3(){
        $npm= session('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Proposal')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Proposal')->
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);
        if(!$dokumen->dokumen){
            return view('layout.mhs.proposal.proposal');
        }
  
            if($dokumen->status_domen == 'disetujui'){
    
                if($bimbingan >= 5){
                    return view('layout.mhs.proposal.proposal3');
                }else{
                    $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();   
                    $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();
                    return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
                }
 
            }else{
                $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();   
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();

                return view('layout.mhs.proposal.proposal2',compact('eval','data','status'));
            }
       
        }
    //   function to translate month to english
  function getcurrentMonth($tanggal){
    $datePart = explode("-",$tanggal);
    $day= $datePart[0];
    $month= $datePart[1];
    $year= $datePart[2];
        $bulan = array(
            'Januari'=> 'January',
            'Februari'=> 'February',
            'Maret'=> 'March',
            'April'=> 'April',
            'Mei'=> 'May',
            'Juni'=> 'June',
            'Juli'=> 'July',
            'Agustus'=> 'August',
            'September'=> 'September',
            'Oktober'=> 'October',
            'November'=> 'November',
            'Desember'=> 'December'
        );
 
        $englishMonth = $bulan[$month];
        
        $englishDate = $day.'-'.$englishMonth.'-'.$year;

        return $englishDate;
      }

    //   function to show weekly laporan
   

    public function laporan(){
        $npm= session('npm');
        $tanggal_mulai= laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
        $startDate = Carbon::parse($tanggal_mulai);
        $tanggal_berakhir= laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
        $endDate = Carbon::parse($tanggal_berakhir);
        
        $currentMonth= Carbon::parse($tanggal_mulai)->format('Y-m-d'); 
        $endMonth= Carbon::parse($tanggal_berakhir)->format('Y-m-d');
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        // Loop through each month (February to July)
        while($currentMonth <= $endMonth) {

            while ($startDate<=$endDate) {

                $weekend = [
                  'start_date' => $startDate->startOfWeek()->format('d'),  // Extract only day
                  'start_month' => $startDate->startOfWeek()->translatedFormat('F'),  // Extract only day
                  'start_year' => $startDate->startOfWeek()->format('Y'),  // Extract only day
                  'end_date' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('d'),
                  'end_month' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->translatedFormat('F'),
                  'end_year' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('Y'),
                ];
    
                $weekends[] = $weekend;
              $startDate = $startDate->addWeek();
      
        } 


        return view('layout.mhs.laporan.laporan',compact('weekends','comment'));

    }
}
    // function to show daily report
    public function laporan2(Request $request,$id){
        $startDate= $request->mulai;

        $startDate= (new MahasiswaController)->getcurrentMonth($startDate);

        $startDate= Carbon::createFromFormat('d-F-Y',$startDate);
        $startDate= $startDate->startOfWeek();
        $endDate= $startDate->copy()->endOfWeek(Carbon::SATURDAY);
        $npm= session('npm');
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        $days= [];
        for($day=$startDate;$day <=$endDate;$day->addDay()){
            $startDate= Carbon::parse($startDate);
  
            $isi = laporan_harian::where('npm','like','%'.$npm.'%')->where('tanggal','like','%'.$day->format('Y-m-d').'%')->first();

            $days[$day->format('d')] = [
               'date'=> $day->translatedFormat('l d F Y'),
               'has_report'=> !is_null($isi),
               'isi'=> $isi ? $isi->isi : '-',
               'id'=> $isi ? $isi->laporan_harian_id : '0',
                
            ];
        }
  
        $week= laporan_mingguan::where('npm','like','%'.$npm.'%')->where('week',$id)->first();

        return view('layout.mhs.laporan.laporan2',compact('days','week','id','comment'));
    }
    // function to show tugas akhir when submit
    public function ta(){
        $npm= session('npm');

        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Tugas Akhir')->
        where('status_domen','disetujui')->get();
        $bimbingan = count($bimbingan);
        $proposal= laporan::where('npm',$npm)->where('type','Proposal')->where('status','Finish')->first();
        
        if(!$dokumen->dokumen){
            
            return view('layout.mhs.ta.ta',compact('proposal'));
        }

            if($dokumen->status_domen == 'disetujui'){

                if($bimbingan >= 14){
                    return view('layout.mhs.ta.ta3',compact('proposal'));
                }else{
                    $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();   
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
               
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;

                return view('layout.mhs.ta.ta2',compact('eval','id','data','status','proposal'));
                }
                
            }else{
          
                $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;

                return view('layout.mhs.ta.ta2',compact('data','id','status','eval','proposal'));
            }
       
        }


    // function to show tugas akhir when revisi
    public function ta2(){
        $npm= session('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Tugas Akhir')->
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);
        $proposal= laporan::where('npm',$npm)->where('type','Proposal')->where('status','Finish')->first();
        if(!$dokumen->dokumen){
            return view('layout.mhs.ta.ta',compact('proposal'));
        }
        if($dokumen->status == "submit" ){
        
            $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
            $id= $dokumen->laporan_id;
            return view('layout.mhs.ta.ta2',compact('eval','data','status','id','proposal'));
        }
        elseif($dokumen->status == "Revisi" ){
 
            $eval = evaluasi::where('npm',$npm)->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
            get();
            $id= $dokumen->laporan_id;
            return view('layout.dsn.ta.ta2',compact('eval','data','status','id','proposal'));
        }elseif($dokumen->status_domen == 'disetujui'){
            if($bimbingan >= 14){
                return view('layout.mhs.ta.ta3',compact('proposal'));
            }else{
       
            $eval = evaluasi::where('npm',$npm)->where('type','Tugas AKhir')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
            get();
            $id= $dokumen->laporan_id;
                return view('layout.mhs.ta.ta2',compact('eval','data','status','id','proposal'));
            }
        }
    }

 
    // function to show tugas akhir when finish
    public function ta3(){
        $npm= session('npm');
       
        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Tugas Akhir')->
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);
        $proposal= laporan::where('npm',$npm)->where('type','Proposal')->where('status','Finish')->first();
        if(!$dokumen->dokumen){
            return view('layout.mhs.ta.ta',compact('proposal'));
        }
        if($bimbingan >= 14){
            return view('layout.mhs.ta.ta3',compact('proposal'));
        }else{
            $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();   
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
        $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
        join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
        where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
        get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
        'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
        $id= $dokumen->laporan_id;


        return view('layout.mhs.ta.ta2',compact('data','id','status','eval','proposal'));
        }

            if($dokumen->status == 'submit'){
                $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();   
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
   
                return view('layout.mhs.ta.ta2',compact('status','data','id','eval','proposal'));
            }elseif($dokumen->status == "Revisi"){
                $eval = evaluasi::where('npm',$npm)->where('type','Tugas Akhir')->get();   
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Tugas Akhir')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
                
                return view('layout.mhs.proposal.ta2',compact('data','id','status','eval','proposal'));
            }elseif($dokumen->status_domen == 'disetujui'){
                return view('layout.mhs.ta.ta3',compact('proposal'));
            }
       
    }
    // function to show report bimbingan
    public function bimbingan(){
        $npm= session('npm');

        $bimbingan = Bimbingan::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $name= dosen::select('name')->where('domen_id',$domen_id)->first()->name;
        

        return view('layout.mhs.bimbingan.bimbingan',compact('bimbingan','name'));
    }
    public function bimbingan2(){
        $npm= session('npm');
        $bimbingan = Bimbingan::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $name= dosen::select('name')->where('domen_id',$domen_id)->first()->name;
        $proposal= laporan::where('npm',$npm)->where('type','Proposal')->where('status','Finish')->first();
        
        return view('layout.mhs.bimbingan.bimbingan2',compact('bimbingan','name','proposal'));
    }
    // function to store proposal or laporan
    public function store(Request $request){
    $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:10458",
            "judul"=>'required',
            "deskripsi"=>'required',
        ],[
            'file.required'=>'Masukkan isi file dokumennya',
            'file.mimes'=> "Upload file revisi dalam bentuk pdf",
            'judul.required'=>'Masukkan isi kolom judulnya',
            'deskripsi.required'=>'Masukkan isi kolom abstraknya'
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
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Proposal dari '. $name .' sudah disubmit';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='Proposal';
            Notifikasi::create($data2);
            return redirect()->route('mhs.proposal2')->with('success','proposal berhasil diupdate');
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
            $data['type']='Tugas Akhir';
            $data['npm']=$npm;
            laporan::create($data);
           
            return redirect()->route('mhs.ta')->with('success','Tugas Akhir berhasil diupdate');
        }
    }
    // function to create report bimbingan
    public function create(Request $request){ 

        $npm= session('npm');
        $data= laporan::select('domen_id')->where('npm','like','%'.$npm.'%')->first();
        $name= dosen::select('name')->where('domen_id',$data->domen_id)->first()->name;
        return view('layout.mhs.bimbingan.create',compact('name'));
    }
    // function to edit report bimbingan
    public function edit(Request $request,$id){
        $data = Bimbingan::where('bimbingan_id',$id)->first();
        $npm= session('npm');
       
        return view('layout.mhs.bimbingan.edit',compact('data'));
    }
 
    // function to convert to english month for function convertIndonesianDateToYmd
    function convertIndonesianMonthToEnglish($month) {
        $englishMonth=[
            'Januari' => '01',
            'Februari' => '02',
            'Maret' => '03',
            'April' => '04',
            'Mei' => '05',
            'Juni' => '06',
            'Juli' => '07',
            'Agustus' => '08',
            'September' => '09',
            'Oktober' => '10',
            'November' => '11',
            'Desember' => '12'
        ];

        return $englishMonth[$month];

    }
    // function to convert to ymd format
    function convertIndonesianDateToYmd($indonesianDate) {
        $dateParts = explode(' ', $indonesianDate); // Split by spaces

      
        $day = $dateParts[1];  // Day name is at index 1
        $month = $this->convertIndonesianMonthToEnglish($dateParts[2]); // Convert month name
        $year = $dateParts[3];
      
        // Create a Carbon object with the extracted parts
        $dateString=$year.'-'.$month.'-'.$day;
  
        $dateObject = Carbon::parse($dateString);

        // Return the date in YMD format
        return $dateObject;
      }
      
    // function to store daily report
    public function store2(Request $request){

        $data['isi']= $request->isi;
        $data['tanggal']= $request->date;
        $tanggal= $this->convertIndonesianDateToYmd($data['tanggal']);

        $data['tanggal']= Carbon::parse($tanggal);

      $npm= session('npm');
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $laporan_harian_id= IdGenerator::generate(
            ['table'=> 'laporan_harian','field'=> 'laporan_harian_id','length'=>5,'prefix'=>'LH']);
        $data['npm']=$npm;
        $data['domen_id']=$domen_id;
        $data['laporan_harian_id']=$laporan_harian_id;
        $data['minggu']=$request->week;
        laporan_harian::create($data);
            return redirect()->route('mhs.laporan');
        }
    // function to store bimbingan
    public function store3(Request $request){
        $request->validate([
            "tanggal"=>"required",
            "topik"=>"required",
            "isi"=>"required",
            "dosen"=>'required'
        ],[
            'tanggal.required'=>'Pilih tanggal Bimbingannya',
            'topik.required'=>'Masukkan isi kolom topik',
            'isi.required'=>'Masukkan di isi kolom Bahasannya',
            "dosen.required"=>'Pilih dosen pembimbingnya'
        ]);
 
        $data['tanggal']= $request->tanggal;
        $data['domen']= $request->dosen;
        $data['topik']= $request->topik;
        $data['isi']= $request->isi ;
        $data['type']= $request->type;
        $data['domen_id']= dosen::select('domen_id')->where('name','like','%'.$data['domen'].'%')->first()->domen_id;
        $data['bimbingan_id']= IdGenerator::generate(
            ['table'=> 'bimbingan','field'=> 'bimbingan_id','length'=>5,'prefix'=>'BM']);
        $data['npm']= FacadesSession::get('npm');
        $data['status']= 'submit';
        bimbingan::create($data);
      
        if($data['type'] == 'Proposal'){
            $npm= session('npm');
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Bimbingan Proposal dari '. $name .' sudah disubmit';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='BimbinganP';
            Notifikasi::create($data2);
            return redirect()->route('mhs.bimbingan');
        }else{
            $npm= session('npm');
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Bimbingan Tugas Akhir dari '. $name .' sudah disubmit';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='BimbinganT';
            Notifikasi::create($data2);
            return redirect()->route('mhs.bimbingan2');
        }

    }
    public function store4(Request $request){
        $data['isi']= $request->isi;
        $data['week']= $request->week;

        $npm= FacadesSession::get('npm');
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $laporan_mingguan_id= IdGenerator::generate(
            ['table'=> 'laporan_mingguan','field'=> 'laporan_mingguan_id','length'=>5,'prefix'=>'LM']);
        $data['npm']=$npm;
        $data['domen_id']=$domen_id;
        $data['laporan_mingguan_id']=$laporan_mingguan_id;
        $data['status']= 'menunggu persetujuan mentor';
        laporan_mingguan::create($data);
        return redirect()->route('mhs.laporan');
    }
    // ini store sks
    
   
  
    public function store6(Request $request){

        $npm= session('npm');

        // $dokumen = syarat::where('syarat','like','%%')->get();

        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:10458|mimes:pdf",
            "judul"=> "required",
            'deskripsi'=> "required"
        ],[
            'file.required'=>'Masukkan isi kolom dokumen',
            'file.mimes'=> "Upload file revisi dalam bentuk pdf",
            'judul.required'=> 'Masukkan isi kolom judulnya',
            'deskripsi.required'=> 'Masukkan isi kolom abstraknya'
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $npm=  session('npm');
          $data3['npm']= $npm;
          $data3['type']= 'Tugas Akhir';
          $data3['domen_id']= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
          $data3['status']= 'submit';
          $data3['judul']=$request->judul;
          $data3['deskripsi']= $request->deskripsi;
          $data3['tanggal_mulai']=laporan::select('tanggal_mulai')->where('npm',$npm)->first()->tanggal_mulai;
          $data3['tanggal_berakhir']=date('Y-m-d',strtotime("+6 months"));
          $dokumen= $request->file('file');
          $filename=$dokumen->getClientOriginalName();
          $path='dokumen/'.$filename;
          $status=$request->status;
          $npm=FacadesSession::get('npm');
          Storage::disk('public')->put($path,file_get_contents($dokumen));
          $data3['dokumen']=$filename;
          $npm= session('npm');
          $data2['notifikasi_id'] = IdGenerator::generate(
              ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
          $data2['npm']= $npm;
          $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
          $data2['sender']= 'mahasiswa';
          $data2['receiver']= 'dosen';
          $name= user::where('npm',$npm)->first()->name;
          $data2['message']='Tugas Akhir dari '. $name .' sudah disubmit';
          $data2['created_at']=now();
          $data2['is_read']=false;
          $data2['type']='Tugas Akhir';
          Notifikasi::create($data2);
    
          laporan::where('npm',$npm)->where('Type','Tugas Akhir')->update($data3);
        
          return redirect()->route('mhs.ta')->with('success','Tugas Akhir Berhasil disimpan');
    }
    public function comment(Request $request){
        $npm= session('npm');
        $data['tanggal'] = Carbon::now()->format('Y-m-d');
        $data['npm']= $npm;
        $data['comment_id'] = IdGenerator::generate(
            ['table' => 'comment', 'field' => 'comment_id', 'length' => 5, 'prefix' => 'CM']);
        $data['domen_id']= laporan::where('npm',$npm)->first()->domen_id;
        $data['isi']= $request->message;
        $data['sender']='mahasiswa';
        $data['receiver']= 'dosen';
        comment::create($data);
        return redirect()->route('mhs.home'); 
    }

    
    // function to update proposal or laporan
    public function update(Request $request){

        $request->validate([
            "revisi"=> "required|mimes:pdf|max:5120",
            "judul"=> "required",
            "abstrak"=>'required'
        ],[
            'revisi.required'=>'Upload file revisi dalam bentuk pdf',
            'revisi.mimes'=> "Upload file revisi dalam bentuk pdf",
             "judul.required"=>"Masukkan isi kolom judul",
             'abstrak.required'=>"Masukkan isi kolom abstrak"
        ]);
    
        $data['judul']= $request->judul;
        $data['status']='Revisi';
        $data['deskripsi']=$request->abstrak;
        $dokumen= $request->file('revisi');
        $filename=$dokumen->getClientOriginalName();
        $path='dokumen/'.$filename;
        $status=$request->status;
        $npm=FacadesSession::get('npm');
        Storage::disk('public')->put($path,file_get_contents($dokumen));
        $data['dokumen']=$filename;
        if($status == 'Proposal'){
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Proposal dari '. $name .' sudah direvisi';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='Proposal';
            Notifikasi::create($data2);
            laporan::where('npm',$npm)->where('type',$status)->update($data);
   
            return redirect()->route('mhs.proposal2')->with('success','Proposal Berhasil diupdate');;
        }else{
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Tugas Akhir dari '. $name .' sudah direvisi';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='Tugas Akhir';
            Notifikasi::create($data2);
            laporan::where('npm',$npm)->where('type',$status)->update($data);
            return redirect()->route('mhs.ta')->with('success','Tugas Akhir Berhasil diupdate');
        }     
    }
    // function to update bimbingan
    public function update2(Request $request,$id){
        $request->validate([
            "tanggal"=>"required",
            "topik"=>"required",
            "isi"=>"required",
        ],[
            'tanggal.required'=>'Pilih tanggal Bimbingannya',
            'topik.required'=>'Masukkan isi kolom topik',
            'isi.required'=>'Masukkan di isi kolom Bahasannya',
        ]);
        $npm = session('npm');
        $data['isi']= $request->isi;
        $data['tanggal']= $request->tanggal;
        $data['topik']= $request->topik;
        $data['status']='Revisi';
        $type=$request->type;
        Bimbingan::where('bimbingan_id',$id)->update($data);
        if($type == 'Proposal'){
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Bimbingan Proposal dari '. $name .' sudah direvisi';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='BimbinganP';
            Notifikasi::create($data2);
            return redirect()->route('mhs.bimbingan');
        }else{
            $data2['notifikasi_id'] = IdGenerator::generate(
                ['table' => 'notifikasi', 'field' => 'notifikasi_id', 'length' => 5, 'prefix' => 'NT']);
            $data2['npm']= $npm;
            $data2['domen_id']=laporan::where('npm',$npm)->first()->domen_id;
            $data2['sender']= 'mahasiswa';
            $data2['receiver']= 'dosen';
            $name= user::where('npm',$npm)->first()->name;
            $data2['message']='Bimbingan Tugas Akhir dari '. $name .' sudah direvisi';
            $data2['created_at']=now();
            $data2['is_read']=false;
            $data2['type']='BimbinganT';
            Notifikasi::create($data2);
            return redirect()->route('mhs.bimbingan2');
        }
           
    

    }
    public function update3(Request $request,$id){
        $data['isi']= $request->isi;
        laporan_harian::find($id)->update($data);
        return redirect()->route('mhs.laporan');
    }
    public function update4(Request $request,$id){
        $data['isi']= $request->isi;
        laporan_mingguan::find($id)->update($data);
        return redirect()->route('mhs.laporan');
    }
    public function delete($id){
        $data= Bimbingan::find($id);
        $status= Bimbingan::where('bimbingan_id',$id)->first()->type;
        if($data){
            $data->delete();
        }
        if($status == 'Tugas Akhir'){
            return redirect()->route('mhs.bimbingan2');
        }else{
            return redirect()->route('mhs.bimbingan');
        }
       
    }
}
