<?php

namespace App\Http\Controllers;

// use Dotenv\Validator;

use App\Models\comment;
use App\Models\laporan;
use App\Models\laporan_harian;
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
    function getCurrentWeekNumber(Carbon $targetDate = null) {
        // If no target date provided, use today
        if (!$targetDate) {
          $targetDate = Carbon::today();
        }
        
        // Set the first day of the year to January 1st
        $oneJan = Carbon::createFromDate($targetDate->year, 1, 1);
      
        // Calculate days since the first day of the year, including current day
        $days = $targetDate->diffInDays($oneJan);
      
        // Calculate the week number (considering ISO 8601 standard with Mondays as start)
        $weekNumber = ceil(($days + $oneJan->dayOfWeek) / 7);
      
        return $weekNumber;
      }
    public function laporan(){
        $npm=FacadesSession::get('npm');
        $tanggal_mulai= laporan::select('tanggal_mulai')->where('npm','like','%'.$npm.'%')->first()->tanggal_mulai;
        $startDate = Carbon::parse($tanggal_mulai);

        $tanggal_berakhir= laporan::select('tanggal_berakhir')->where('npm','like','%'.$npm.'%')->first()->tanggal_berakhir;
        
        $endDate = Carbon::parse($tanggal_berakhir);
        
        $currentMonth= $startDate->month;
        $endMonth= $endDate->month;
        $currentWeek = (new MahasiswaController)->getCurrentWeekNumber();

        // Loop through each month (February to July)
        for($currentMonth ;$currentMonth<=$endMonth;$currentMonth++) {
          
            while ($startDate<=$endDate) {
                $weekend = [
                  'start_date' => $startDate->startOfWeek()->format('d'),  // Extract only day
                  'start_month' => $startDate->startOfWeek()->format('F'),  // Extract only day
                  'start_year' => $startDate->startOfWeek()->format('Y'),  // Extract only day
                  'end_date' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('d'),
                  'end_month' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('F'),
                  'end_year' => $startDate->copy()->endOfWeek(Carbon::SATURDAY)->format('Y'),
                ];
    
                if ($startDate->weekOfYear == $currentWeek) {
                    array_unshift($weekends, $weekend);
                  } else {
                    $weekends[] = $weekend;
                  }

                $startDate = $startDate->addWeek();

        }
 
        return view('layout.mhs.laporan.laporan',compact('weekends'));
    }
}
   
    public function laporan2(String $startDate,String $endDate,String $startMonth,String $endMonth,String $startYear,String $endYear){
        // Get the start of the current week (Sunday)
        $startDate = Carbon::parse($startDate.'-'.$startMonth.'-'.$startYear);
        $endDate = Carbon::parse($endDate.'-'.$endMonth.'-'.$endYear);
            $days= [];
            for($day=$startDate;$day<=$endDate;$day->addDay()){

                $days[] = $day->format('l d F Y');
            }
          // Loop through each week within the month

          return view('layout.mhs.laporan.laporan2',compact('days'));
        }
    public function laporan3(){
        $startDate= FacadesSession::get('tanggal');
        $startDate= Carbon::parse($startDate);
        $startDate= $startDate->startOfWeek();
        $endDate= $startDate->copy()->endOfWeek(Carbon::SATURDAY);
        $npm=FacadesSession::get('npm');
        $days= [];
        for($day=$startDate;$day <=$endDate;$day->addDay()){
            $startDate= Carbon::parse($startDate);
            $days[] = $day->locale('id')->format('l d F Y');

            $isi[]=  laporan_harian::select(DB::raw('isi'), DB::raw('DATE_FORMAT(tanggal, "%W %d %M %Y") AS tanggal'))
            ->where('npm', 'like', '%'.$npm.'%')
            ->where('tanggal', 'like', '%'.$day->format('Y-m-d').'%')
            ->get();
        
        }
        // dd($isi);

        return view('layout.mhs.laporan.laporan3',compact('days','isi'));
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
    public function store2(Request $request){


        $data['isi']= $request->isi;
        $data['tanggal']= $request->date;
        $data['tanggal']= Carbon::parse($data['tanggal']);
        
        FacadesSession::put('tanggal',$request->date);
        $npm=FacadesSession::get('npm');
        $domen_id= laporan::select('domen_id')->where('npm',$npm)->first()->domen_id;
        $laporan_harian_id= IdGenerator::generate(
            ['table'=> 'laporan_harian','field'=> 'laporan_harian_id','length'=>5,'prefix'=>'LH']);
        $data['npm']=$npm;
        $data['domen_id']=$domen_id;
        $data['laporan_harian_id']=$laporan_harian_id;
        laporan_harian::create($data);
            return redirect()->route('mhs.laporan3');
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
            ['table'=> 'laporan','field'=> 'comment_id','length'=>5,'prefix'=>'CM']);
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
