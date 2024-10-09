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
    public function home(){
        $npm= session('npm');
        $bimbingan=Bimbingan::where('npm','like','%'.$npm.'%')
        ->where('status','disetujui')->get();
        $count= count($bimbingan);
        $judul= laporan::select('judul')->where('npm',$npm)->where('type','Proposal')->get();
        $notifikasi= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->
        orderBy('comment_id','desc')->first()->notifikasi ?? '';
        $notifikasi2= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
        orderBy('comment_id','desc')->first()->notifikasi ?? '';
        $submit = laporan::where('tanggal_submit','<',Carbon::now()->subDays(30))->
        where('npm',$npm)->where('type','Proposal')->get();

        if($submit){
            $belum_submit= 'Peringatan Proposal belum di submit dalam 30 hari ';
        }
  
        return view('layout.mhs.dashboard',compact('npm','count','judul','notifikasi','belum_submit','notifikasi2'));
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
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);

        if(!$dokumen->dokumen){
            return view('layout.mhs.proposal.proposal');
        }

            if($dokumen->status_domen == 'disetujui'){
    
                if($bimbingan >= 5){
                    return view('layout.mhs.proposal.proposal3');
                }else{
                $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();
    
             
                    return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
                }
 
            }else{
                $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();

                return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
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
            $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();
            return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
        }
        elseif($dokumen->status == "Revisi" ){
            $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();
            return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
        }elseif($dokumen->status_domen == 'disetujui'){
            if($bimbingan >= 5){
                return view('layout.mhs.proposal.proposal3');
            }else{
            $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
            'laporan.laporan_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get();
                return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
            }
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
                    $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
                    $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();
                    return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
                }
 
            }else{
                $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();

                return view('layout.mhs.proposal.proposal2',compact('komment','data','status'));
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
    public function syarat(){
        $npm= session('npm');
        $datasks= syarat::where('npm',$npm)->where('syarat','sks')->get
        (['syarat','file','status','dateac']);
        $datamagang= syarat::where('npm',$npm)->where('syarat','magang')->get
        (['syarat','file','status','dateac']);
        $dataipk= syarat::where('npm',$npm)->where('syarat','ipk')->get
        (['syarat','file','status','dateac']);
        $statussks= syarat::where('npm',$npm)->where('syarat','sks')->first()->status ?? null;
        $statusipk= syarat::where('npm',$npm)->where('syarat','ipk')->first()->status ?? null;
        $statusmagang= syarat::where('npm',$npm)->where('syarat','magang')->first()->status ?? null;

        return view('layout.mhs.proposal.syarat',compact('datasks','datamagang','dataipk','statussks','statusipk','statusmagang'));
    }
   function getStatus($s){
        return[
            'status' => $s->status ?? 'status tidak ada',
            'syarat' => $s->syarat ?? 'syarat tidak ada'
        ];
    }
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
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);
        if(!$dokumen->dokumen){
            return view('layout.mhs.ta.ta');
        }

            if($dokumen->status_domen == 'disetujui'){

                if($bimbingan >= 14){
                    return view('layout.mhs.ta.ta3');
                }else{
                    $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                    $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;


                return view('layout.mhs.ta.ta2',compact('comment','proposal','id','status'));
                }
                
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;


                return view('layout.mhs.ta.ta2',compact('comment','proposal','id','status'));
            }
       
        }


    // function to show tugas akhir when revisi
    public function ta2(){
        $npm= session('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();
        $bimbingan = bimbingan::where('npm',$npm)->where('Type','Tugas Akhir')->
        where('status','disetujui')->get();
        $bimbingan = count($bimbingan);
        if(!$dokumen->dokumen){
            return view('layout.mhs.ta.ta');
        }if($dokumen->status_domen == 'disetujui'){

            if($bimbingan >= 14){
                return view('layout.mhs.ta.ta3');
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
            $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
            get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
            $id= $dokumen->laporan_id;


            return view('layout.mhs.ta.ta2',compact('comment','proposal','id','status'));
            }

            if($dokumen->status == 'submit'){
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
   
                return view('layout.mhs.ta.ta2',compact('comment','status','proposal','id'));
            }elseif($dokumen->status == "Revisi"){
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();;
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
                
                return view('layout.mhs.proposal.ta2',compact('comment','proposal','id','status'));
            }elseif($dokumen->status_domen == 'disetujui'){
                return view('layout.mhs.ta.ta3');
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
        if(!$dokumen->dokumen){
            return view('layout.mhs.ta.ta');
        }
        if($bimbingan >= 14){
            return view('layout.mhs.ta.ta3');
        }else{
            $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
            $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
        $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
        join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
        where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
        get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
        'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
        $id= $dokumen->laporan_id;


        return view('layout.mhs.ta.ta2',compact('comment','proposal','id','status'));
        }

            if($dokumen->status == 'submit'){
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
   
                return view('layout.mhs.ta.ta2',compact('comment','status','proposal','id'));
            }elseif($dokumen->status == "Revisi"){
                $comment= comment::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
                $status= laporan::select('status_domen')->where('npm',$npm)->where('type','Proposal')->first();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
                
                return view('layout.mhs.proposal.ta2',compact('comment','proposal','id','status'));
            }elseif($dokumen->status_domen == 'disetujui'){
                return view('layout.mhs.ta.ta3');
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
       

        return view('layout.mhs.bimbingan.bimbingan2',compact('bimbingan','name'));
    }
    // function to store proposal or laporan
    public function store(Request $request){
    $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:10458",
            "judul"=>'required',
            "deskripsi"=>'required',
        ],[
            'file.required'=>'Harap isi file dokumennya',
            'judul.required'=>'Harap isikolom judulnya',
            'deskripsi.required'=>'Harap isi kolom abstraknya'
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
        $data['tanggal_submit']= Carbon::now();
        if($status== 'Proposal'){
            laporan::where('npm',$npm)->where('type',$status)->update($data);
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
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        return view('layout.mhs.bimbingan.create',compact('name','comment'));
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
            'tanggal.required'=>'Harap pilih tanggal Bimbingannya',
            'topik.required'=>'harap isi kolom topik',
            'isi.required'=>'Harap di isi kolom Bahasannya',
            "dosen.required"=>'Harap pilih dosen pembimbingnya'
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
            return redirect()->route('mhs.bimbingan');
        }else{
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
    public function store5(Request $request){
        $npm= session('npm');

        // $dokumen = syarat::where('syarat','like','%%')->get();

        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:2048|mimes:png,jpg,jpeg,pdf",
        ],[
            'file.required'=> 'Harap upload filenya',
            'file.max'=>'File tidak boleh lebih dari 2MB.',
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $file= $request->file('file');
        $name= $file->getClientOriginalName();
        
            $dokumen2= syarat::where('syarat','sks')->where('npm',$npm)->first();
            // dd($dokumen2);

            if($dokumen2){
                $data['file']= $name;
                $id= $dokumen2->id_syarat;
                syarat::where('id_syarat',$id)->update($data);
                $path='documents/'.$name;
                Storage::disk('public')->put($path,file_get_contents($file));
                return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
            }else{
            
            $laporan_id= IdGenerator::generate(
            [  'table'=> 'syarat','field'=> 'id_syarat','length'=>5,'prefix'=>'SY']);
      
            $data['id_syarat']= $laporan_id;
            $data['syarat']= 'sks';

            $data['file']= $name;
            $data['dateupload']= Carbon::now();
            $data['npm']= $npm;
            $data['status']= 'submit';
          
    
            syarat::create($data);
            $path='documents/'.$name;
            Storage::disk('public')->put($path,file_get_contents($file));
       
        return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
    } 
}
    public function storeMagang(Request $request){
        $npm= session('npm');

        // $dokumen = syarat::where('syarat','like','%%')->get();

        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:2048|mimes:png,jpg,jpeg,pdf",
        ],[
            'file.required'=> 'Harap upload filenya',
            'file.max'=>'File tidak boleh lebih dari 2MB.',
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $file= $request->file('file');
        $name= $file->getClientOriginalName();
        
        $dokumen2= syarat::where('syarat','magang')->where('npm',$npm)->first();
      
            if($dokumen2){
                $data['file']= $name;
  
                $id= $dokumen2->id_syarat;
                syarat::where('id_syarat',$id)->update($data);
                $path='documents/'.$name;
                Storage::disk('public')->put($path,file_get_contents($file));
                return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
            }else{
            
            $laporan_id= IdGenerator::generate(
            [  'table'=> 'syarat','field'=> 'id_syarat','length'=>5,'prefix'=>'SY']);
      
            $data['id_syarat']= $laporan_id;
            $data['syarat']= 'magang';

            $data['file']= $name;
            $data['dateupload']= Carbon::now();
            $data['npm']= $npm;
            $data['status']= 'submit';
          
    
            syarat::create($data);
            $path='documents/'.$name;
            Storage::disk('public')->put($path,file_get_contents($file));
       
        return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
    }
}
    public function storeIpk(Request $request){
        $npm= session('npm');
        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:2048|mimes:png,jpg,jpeg,pdf",
        ],[
            'file.required'=> 'Harap upload filenya',
            'file.max'=>'File tidak boleh lebih dari 2MB.',
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $file= $request->file('file');
        $name= $file->getClientOriginalName();
        
        $dokumen2= syarat::where('syarat','ipk')->where('npm',$npm)->first();
            if($dokumen2){
                $data['file']= $name;
  
                $id= $dokumen2->id_syarat;
                syarat::where('id_syarat',$id)->update($data);
                $path='documents/'.$name;
                Storage::disk('public')->put($path,file_get_contents($file));
                return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
            }else{
            
            $laporan_id= IdGenerator::generate(
            [  'table'=> 'syarat','field'=> 'id_syarat','length'=>5,'prefix'=>'SY']);
      
            $data['id_syarat']= $laporan_id;
            $data['syarat']= 'ipk';

            $data['file']= $name;
            $data['dateupload']= Carbon::now();
            $data['npm']= $npm;
            $data['status']= 'submit';
          
    
            syarat::create($data);
            $path='documents/'.$name;
            Storage::disk('public')->put($path,file_get_contents($file));
       
        return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
    }
}
    public function store6(Request $request){

        $npm= session('npm');

        // $dokumen = syarat::where('syarat','like','%%')->get();

        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:10458|mimes:png,jpg,jpeg,pdf",
            "judul"=> "required",
            'deskripsi'=> "required"
        ],[
            'file.required'=>'Harap isi kolom dokumen',
            'judul.required'=> 'Harap isi kolom judulnya',
            'deskripsi.required'=> 'Harap isi kolom abstraknya'
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
    
          laporan::where('npm',$npm)->where('Type','Tugas Akhir')->update($data3);
        
          return redirect()->route('mhs.ta')->with('success','Tugas Akhir Berhasil disimpan');
    }

    
    // function to update proposal or laporan
    public function update(Request $request){
        $validator= Validator::make($request->all(),[
            "revisi"=> "required|mimes:pdf|max:5120"
        ],[
            'revisi.required'=>'Harap upload file revisi dalam bentuk pdf'
        ]);
        $request->validate([
            "revisi"=> "required|mimes:pdf|max:5120"
        ],[
            'revisi.required'=>'Harap upload file revisi dalam bentuk pdf'
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
        $data3['notifikasi']= 'sudah dibaca';
        $data['tanggal_submit']=Carbon::now(); 
        comment::where('npm',$npm)->update($data3);
        if($status== 'Proposal'){
            laporan::where('npm',$npm)->where('type',$status)->update($data);
   
            return redirect()->route('mhs.proposal2')->with('success','Proposal Berhasil diupdate');;
        }else{
 
            laporan::where('npm',$npm)->where('type',$status)->update($data);
            return redirect()->route('mhs.ta')->with('success','Tugas Akhir Berhasil diupdate');
        }     
    }
    // function to update bimbingan
    public function update2(Request $request,$id){
        $data['isi']= $request->isi;
        $data['tanggal']= $request->tanggal;
        $data['topik']= $request->topik;
        $data['status']='Revisi';
        $type=$request->type;
        Bimbingan::where('bimbingan_id',$id)->update($data);
        if($type == 'Proposal'){
            return redirect()->route('mhs.bimbingan');
        }else{
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
