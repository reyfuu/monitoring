@extends('layout.mhs-main')
@section('title')
<title>Syarat</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Syarat Proposal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

  <br>
  <section class="content">
    <div class="container-fluid">
        <div class="table-responsive">
          @if (session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
          @elseif(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error )
                  <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
            <table class="table table-hover text-nowrap">
              <thead>
                <th>No</th>
                <th>Syarat Ujian</th>
                <th>Keterangan</th>
                <th>File Upload</th>
                <th>Tanggal Validasi</th>
                <th>Valid</th>
                <th>Aksi</th>
              </thead>
              <tbody>
                <tr>
                  @php
                  $syarat=[
                  'Kredit Poin Kegiatan Kemahasiswaan > 200 Poin---Kredit Poin Kegiatan Kemahasiswaan (KPKK) dengan nilai lebih besar dari 200 Poin
                      ',
                  'Lulus 120 SKS---Telah lulus 120 SKS',
                  'Lulus In House---Telah lulus in house',
                  'Lulus LKMM Etika Moral---Telah lulus LKMM Etika Moral',
                  'Lulus LKMM-TD---Telah lulus LKMM-TD',
                  'Lulus LKMM-TM---Telah lulus LKMM-TM',
                  'Lulus Out Bond---Telah lulus out bond',
                  'Lunas Administrasi Keuangan---Telah melunasi administrasi keuangan ( SPP semester sebelumnya dan Dana Pengembangan)',
                  'Maksimal Nilai D 10 % Dari Total SKS---Maksimal untuk nilai D adalah 10 % dari total SKS',
                  'Sedang Menempuh 144 SKS---Sedang menempuh 144 SKS saat mengajukan proposal',
                  'TOEFL > 400---Skor test TOEFL lebih besar dari 400'
                ];
                  $keterangan = [
                  'Kredit Poin Kegiatan Kemahasiswaan > 200 Poin',
                  'Lulus 120 SKS',
                  'Lulus In House',
                  'Lulus LKMM Etika Moral',
                  'Lulus LKMM-TD',
                  'Lulus LKMM-TM',
                  'Lulus Out Bond',
                  'Lunas Administrasi Keuangan',
                  'Maksimal Nilai D 10 % Dari Total SKS',
                  'Sedang Menempuh 144 SKS',
                  'TOEFL > 400'
              ];
              $file = [
                  'kpk',
                  'sks',
                  'inhouse',
                  'wm',
                  'lkmmtd',
                  'lkmmtm',
                  'outbond',
                  'spp',
                  'nilai',
                  'sumsks',
                  'toefl'
  
                ];
                  @endphp
                  @foreach ($syarat as $index=>$s)
      

                  <form action="{{ route('mhs.store5') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <td >{{ $loop->iteration }}</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;" >{{ $s }}</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;">{{ $keterangan[$index] }}</td>
                    <td >
                        <input type="file" class="form-control" name="file{{ $file[$index] }}" >
      
                        <div style="white-space: pre-wrap;word-wrap: break-word;" class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                    </td >
                    <td>
                     @foreach ($data as $d)
                         
                     @if ($d->dateac && $d->syarat==$file[$index])
                     {{ $d->dateac }}
           
                    @else
             
                    @endif
                      @endforeach
   
                    </td>
                    <td>
                      @foreach ($data as $d)
                      @if ($d->status  && $d->syarat== $file[$index])
                        {{ $d->status }}
               
                     @endif
                     @endforeach
                     
                    </td>

                    <td>
                

                          <button  type="submit" class="btn btn-success text-end">Simpan</button> 

                 
                    </td>
           
                  </form>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</section>
</div>
   
@endsection