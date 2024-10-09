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
              <li class="breadcrumb-item active">Dashboard Syarat Proposal</li>
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
          @php
          $syarat=[
              'Lulus 135 SKS',
              'Lulus Mata Kuliah Magang',
              'Minimal IPK 2,5'
            ];
          $keterangan=[
            'Lulus 135 SKS',
              'Lulus Magang',
              'Minimal IPK 2,5'
          ];
              $file = [
                'sks',
                'magang',
                'ipk'
            ];
          @endphp
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
                
                  <form id="sks" action="{{ route('mhs.store5') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <td>
                      1</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;" >Lulus 135 SKS---Telah lulus 135 SKS</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;">Lulus 135 SKS</td>
                    <td >
           
                        <input type="file" class="form-control" name="file" >
      
                        <div style="white-space: pre-wrap;word-wrap: break-word;" class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                      </td >
                    <td>
                         @foreach ($datasks as $d)
                         
                     @if ($d->dateac )
                     {{ $d->dateac }}
           
                    @else
             
                    @endif
                      @endforeach
                    </td>
                    <td>
                      @foreach ($datasks as $d)
                      @if ($d->status  )
                        {{ $d->status }}
               
                     @endif
                     @endforeach
                    </td>

                    <td>
                      @if ($statussks == 'disetujui')
                          
                      @else
                      <button  type="submit" class="btn btn-success text-end">Simpan</button> 
                      @endif
                        
                    </td>
                 
                  </form>
                </tr>
                <tr>
                  <form id="magang" action="{{ route('mhs.storeMagang') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <td >2</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;" >Telah Melaksanakan Tugas Magang</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;">Lulus Mata Kuliah Magang</td>
                    <td >
                      <form action="{{ route('mhs.storeMagang') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" class="form-control" name="file" >
      
                        <div style="white-space: pre-wrap;word-wrap: break-word;" class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                      </td >
                    <td>
                     @foreach ($datamagang as $d)
                         
                     @if ($d->dateac )
                     {{ $d->dateac }}
           
                    @else
             
                    @endif
                      @endforeach
   
                    </td>
                    <td>
                      @foreach ($datamagang as $d)
                      @if ($d->status )
                        {{ $d->status }}
               
                     @endif
                     @endforeach
                     
                    </td>

                    <td>
                
                      @if ($statusmagang == 'disetujui')
                          
                      @else
                      <button  type="submit" class="btn btn-success text-end">Simpan</button> 
                      @endif
                          

                    </td>
                  </form>
                </tr>
                <tr>
                  <form action="{{ route('mhs.storeIpk') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <td >3</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;" >IPK minimal 2,5</td>
                    <td style="white-space: pre-wrap;word-wrap: break-word;">IPK minimal 2,5</td>
                    <td >
                        <input type="file" class="form-control" name="file" >
      
                        <div style="white-space: pre-wrap;word-wrap: break-word;" class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>

                      </td >
                    <td>
                     @foreach ($dataipk as $d)
                         
                     @if ($d->dateac )
                     {{ $d->dateac }}
           
                    @else
             
                    @endif
                      @endforeach
   
                    </td>
                    <td>
                      @foreach ($dataipk as $d)
                      @if ($d->status  )
                        {{ $d->status }}
               
                     @endif
                     @endforeach
                     
                    </td>

                    <td>
                      @if ($statusipk == 'disetujui')
                          
                      @else
                      <button  type="submit" class="btn btn-success text-end">Simpan</button> 
                      @endif

                       
                        </form>
                    </td>
             
                </tr>

            </tbody>
        </table>
    </div>
</div>
</section>
</div>
@endsection