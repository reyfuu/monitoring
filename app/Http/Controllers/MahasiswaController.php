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
        $judul= laporan::select('judul')->where('npm',$npm)->where('type','Proposal')->first();

        return view('layout.mhs.dashboard',compact('count','judul'));
    }

    // function show proposal when  submit
    public function proposal(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Proposal')->first();

        if(!$dokumen->dokumen){
            return view('layout.mhs.proposal.proposal');
        }
            if($dokumen->status == 'disetujui'){
                return view('layout.mhs.proposal.proposal3');
            }else{
                $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
                $data= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                select('mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi',
                'laporan.laporan_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
                get();
                // foreach($data as $d){
                //     dd($d->dokumen);
                // }
    

                return view('layout.mhs.proposal.proposal2',compact('komment','data'));
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
    // function show proposal when revisi
    public function proposal2(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Proposal')->first();

        if($dokumen->status == "Revisi"){
            $komment= comment::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
            $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
            join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
            where('laporan.npm','like','%'.$npm.'%')->where('type','Proposal')->
            get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
            'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
            $id= $dokumen->laporan_id;
            return view('layout.mhs.proposal.proposal2',compact('komment','proposal','id'));
        }else{
            return view('layout.mhs.proposal.proposal3');
        }

    }
    public function upload(){
        return view('layout.mhs.proposal.upload');
    }
    // function show proposal when finish
    public function proposal3(){
        $npm=FacadesSession::get('npm');
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        return view('layout.mhs.proposal.proposal3',compact('comment'));
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
        $npm= FacadesSession::get('npm');
        $data= syarat::where('npm',$npm)->get
        (['syarat','file','status']);
        $status= syarat::where('npm',$npm)
        ->get(['status']);

        return view('layout.mhs.proposal.syarat',compact('data'));
    }
    public function laporan(){
        $npm=FacadesSession::get('npm');
        $tanggal_mulai= laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
        $startDate = Carbon::parse($tanggal_mulai);

        $tanggal_berakhir= laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
        
        $endDate = Carbon::parse($tanggal_berakhir);
        
        $currentMonth= $startDate->month;
        $endMonth= $endDate->month;
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();

        // Loop through each month (February to July)
        for($currentMonth ;$currentMonth<=$endMonth;$currentMonth++) {

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
        $npm=FacadesSession::get('npm');
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
  
        $week= laporan_mingguan::where('npm','like','%'.$npm.'%')->where('week','like','%'.$id.'%')->first();

        return view('layout.mhs.laporan.laporan2',compact('days','week','id','comment'));
    }
    // function to show tugas akhir when submit
    public function ta(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();
        if($dokumen == null){
            return view('layout.mhs.ta.ta');
        }

            if($dokumen->status == 'Finish'){
                return view('layout.mhs.ta.ta3');
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->get();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
   
                return view('layout.mhs.ta.ta2',compact('comment','proposal','id'));
            }
       
        }


    // function to show tugas akhir when revisi
    public function ta2(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::where('npm',$npm)->where('type','Tugas Akhir')->first();

   

            if($dokumen->status == 'Finish'){
                return view('layout.mhs.ta.ta3');
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->get();
                $proposal= laporan::join('mahasiswa', 'mahasiswa.npm', '=', 'laporan.npm')->
                join('domen', 'domen.domen_id', '=', 'laporan.domen_id')->
                where('laporan.npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->
                get(['mahasiswa.name as name','mahasiswa.npm as npm','laporan.judul as judul',
                'Laporan.dokumen as dokumen','domen.name as domen','Laporan.deskripsi as deskripsi']);
                $id= $dokumen->laporan_id;
   
                return view('layout.mhs.proposal.ta2',compact('comment','proposal','id'));
            }
       
        
    }
    // function to show tugas akhir when finish
    public function ta3(){
        $npm=FacadesSession::get('npm');
       
        return view('layout.mhs.ta.ta3');
    }
    // function to show report bimbingan
    public function bimbingan(){
        $npm=FacadesSession::get('npm');
        $bimbingan = Bimbingan::where('npm','like','%'.$npm.'%')->where('type','Proposal')->get();
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $name= dosen::select('name')->where('domen_id',$domen_id)->first()->name;


        return view('layout.mhs.bimbingan.bimbingan',compact('bimbingan','name'));
    }
    public function bimbingan2(){
        $npm=FacadesSession::get('npm');
        $bimbingan = Bimbingan::where('npm','like','%'.$npm.'%')->where('type','Tugas Akhir')->get();
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $name= dosen::select('name')->where('domen_id',$domen_id)->first()->name;
       

        return view('layout.mhs.bimbingan.bimbingan2',compact('bimbingan','name'));
    }
    // function to store proposal or laporan
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
            $data['type']='Tugas Akhir';
            $data['npm']=$npm;
            laporan::create($data);
            notify()->success('Welcome to Laravel Notify ⚡️') or notify()->success('Welcome to Laravel Notify ⚡️', 'My custom title');
            return redirect()->route('mhs.ta');
        }
    }
    // function to create report bimbingan
    public function create(Request $request){ 

        $npm=FacadesSession::get('npm');
        $data= laporan::select('domen_id')->where('npm','like','%'.$npm.'%')->first();
        $name= dosen::select('name')->where('domen_id',$data->domen_id)->first()->name;
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        return view('layout.mhs.bimbingan.create',compact('name','comment'));
    }
    // function to edit report bimbingan
    public function edit(Request $request,$id){
        $data = Bimbingan::where('bimbingan_id',$id)->first();
        $npm=FacadesSession::get('npm');
       
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

        $npm=FacadesSession::get('npm');
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
        $npm= FacadesSession::get('npm');

        // $dokumen = syarat::where('syarat','like','%%')->get();

        $validator= Validator::make($request->all(),[
            "file.*"=> "required|file|max:2048|mimes:png,jpg,jpeg,pdf",
   
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $dokumen= $request->allFiles();

        foreach($dokumen as $key=>$files){
            $name= substr($key,4);
            $file= $files->getClientOriginalName();
        }
 

            $dokumen2= syarat::where('syarat',$name)->get('id_syarat');

            if(empty($dokumen2) ){
                $data['file']= $file;
                $id= $dokumen2->pluck('id_syarat');
                syarat::where('id_syarat',$id)->update($data);
                return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');
            }else{
            
            $laporan_id= IdGenerator::generate(
            [  'table'=> 'syarat','field'=> 'id_syarat','length'=>5,'prefix'=>'SY']);
      
            $data['id_syarat']= $laporan_id;
            $data['syarat']= $name;

            $data['file']= $file;
            $data['dateupload']= Carbon::now();
            $data['npm']= $npm;
            $data['status']= 'submit';
            $filepath= $files->storeAs('documents',$data['file'],'public');
    
            syarat::create($data);
        
       
        return redirect()->route('mhs.syarat')->with('success','File Berhasil Ditambahkan');

            }
 } 

    
    // function to update proposal or laporan
    public function update(Request $request){
        $validator= Validator::make($request->all(),[
            "file"=> "required|mimes:pdf|max:5120"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        $data['judul']= $request->judul;
        $data['status']='Revisi';
        $data['deskripsi']=$request->abstrak;
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
 
            laporan::where('npm',$npm)->where('type',$status)->update($data);
            return redirect()->route('mhs.ta');
        }     
    }
    // function to update bimbingan
    public function update2(Request $request,$id){
        $data['isi']= $request->isi;
        $data['tanggal']= $request->tanggal;
        $data['topik']= $request->topik;
        Bimbingan::where('npm',$id)->where('tanggal',$data['tanggal'])->update($data);
        return redirect()->route('mhs.bimbingan');
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
        if($data){
            $data->delete();
        }
        return redirect()->route('mhs.bimbingan');
    }
}
