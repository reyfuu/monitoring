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



class MahasiswaController extends Controller
{
    public function home(){
        $npm=FacadesSession::get('npm');
        $bimbingan=Bimbingan::where('npm','like','%'.$npm.'%')
        ->where('status','Approve')->get();
        $count= count($bimbingan);
        $judul= laporan::select('judul')->where('npm',$npm)->where('type','Laporan')->first();
        return view('layout.mhs.dashboard',compact('count','judul'));
    }

    // function show proposal when  submit
    public function proposal(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('type','Proposal')->exists();
        $status= laporan::select('dokumen')->where('npm',$npm)->where('status','Finish')->exists();


        if($dokumen){
            if($status == 'Finish'){
                return view('layout.mhs.proposal.proposal3');
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->get();
                $status= laporan::select('status')->where('npm',$npm)->where('type','Proposal')->first()->status;
                $judul= laporan::select('judul')->where('npm',$npm)->where('type','Proposal')->first()->judul;
                return view('layout.mhs.proposal.proposal2',compact('comment','status','judul'));
            }
        }else{
            $npm=FacadesSession::get('npm');
            return view('layout.mhs.proposal.proposal',compact('comment'));
        }
     
    }
    // function show proposal when revisi
    public function proposal2(){
        $npm=FacadesSession::get('npm');
        $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('status','Finish')->exists();
        if(!$dokumen){
            $npm=FacadesSession::get('npm');
            $comment= comment::where('npm','like','%'.$npm.'%')->get();
            return view('layout.mhs.proposal.proposal2',compact('comment'));
        }else{
            return view('layout.mhs.proposal.proposal3');
        }

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
    
        $status= 'disetujui';
        return view('layout.mhs.proposal.syarat',compact('status'));
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
        $dokumen= laporan::select('dokumen')->where('npm',$npm)->where('type','Laporan')->first()->dokumen;
        $status= laporan::select('dokumen')->where('npm',$npm)->where('status','Finish')->exists();
        if($dokumen){
            if($status == 'Finish'){
                return view('layout.mhs.ta.ta3');
            }else{
                $comment= comment::where('npm','like','%'.$npm.'%')->get();
                $status= laporan::select('status')->where('npm',$npm)->where('type','Laporan')->first()->status;
                $judul= laporan::select('judul')->where('npm',$npm)->where('type','Laporan')->first()->judul;
                return view('layout.mhs.ta.ta2',compact('comment','status','judul'));
            }
        }else{
            $npm=FacadesSession::get('npm');
            return view('layout.mhs.ta.ta',compact('comment'));
        }
    }
    // function to show tugas akhir when revisi
    public function ta2(){
        $npm=FacadesSession::get('npm');
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        return view('layout.mhs.ta.ta2',compact('comment'));
    }
    // function to show tugas akhir when finish
    public function ta3(){
        $npm=FacadesSession::get('npm');
       
        return view('layout.mhs.ta.ta3');
    }
    // function to show report bimbingan
    public function bimbingan(){
        $npm=FacadesSession::get('npm');
        $bimbingan = Bimbingan::where('npm','like','%'.$npm.'%')->get();
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $name= dosen::select('name')->where('domen_id',$domen_id)->first()->name;
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();

        return view('layout.mhs.bimbingan.bimbingan',compact('bimbingan','comment','name'));
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
            $data['type']='Laporan';
            $data['npm']=$npm;
            laporan::create($data);
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
        $data = Bimbingan::where('npm',$id)->first();
        $npm=FacadesSession::get('npm');
        $comment= comment::orderBy('tanggal','desc')->where('npm','like','%'.$npm.'%')->take(5)->get();
        return view('layout.mhs.bimbingan.edit',compact('data','comment'));
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
        $data['domen_id']= dosen::select('domen_id')->where('name','like','%'.$data['domen'].'%')->first()->domen_id;
        $data['bimbingan_id']= IdGenerator::generate(
            ['table'=> 'bimbingan','field'=> 'bimbingan_id','length'=>5,'prefix'=>'BM']);
        $data['npm']= FacadesSession::get('npm');
        $data['status']= 'submit';
        bimbingan::create($data);
        return redirect()->route('mhs.bimbingan');
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
    public function store5(Request $request){


        $npm= FacadesSession::get('npm');
        $files= $request->allFiles();
        $laporan_id= IdGenerator::generate(
            ['table'=> 'laporan','field'=> 'laporan_id','length'=>5,'prefix'=>'LP']);
        foreach ($files as $file) {
            $data['id_syarat']= $laporan_id;
            $data['file']= $file->getClientOriginalName();
            $data['name']= $request->file();
            $data['dateupload']= Carbon::now();
            $data['npm']= $npm;
            $data['status']= 'submit';
            syarat::create($data);
        }
      

        $validator= Validator::make($request->all(),[
            "file"=> "required|file|max:2048|mimes:png,jpg,jpeg,pdf"
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

  
       
        return redirect()->route('mhs.dashboard');

        


    }
    // function to update proposal or laporan
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
  

        if($status== 'Proposal'){
            laporan::where('npm',$npm)->where('type',$status)->update($data);
   
            return redirect()->route('mhs.proposal2');
        }else{
 
            laporan::create($data);
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
