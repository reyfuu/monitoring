@extends('layout.dsn-main')
@section('title')

<title>Dashboard Tugas Akhir</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Tugas Akhir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Tugas Akhir</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-12">
          <div class="card"> 
            <div class="card-header">


         
          
            <!-- show data -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach ($data as $d)
                  <tr>
                      <td>{{ $d->mahasiswa }}</td>
                      <td>{{ $d->judul }}</td>
                      <td>
         
                        @if ($d->dokumen)
                        <a href="{{ route('dmn.viewTa',['id'=>$d->dokumen ]) }}">
                          <img src="{{ asset('img/pdf.png') }}" style="width: 25%">
                        </a>
                        @else
                            Belum submit 
                        @endif
                      </td>
                      <td>
                        @if ($d->status)
                          {{ $d->status }}
                        @else
                            belum submit
                        @endif
                      </td>

                      <td>
                        <a href="{{ route('dmn.rekapt',$d->npm) }}" class="btn btn-primary text-end" >Detail</a>
                        <br>
                        @if ($d->status == 'Finish')
                       
                        @else
                        <br>
                        <a href="{{ route('dmn.setujut',$d->laporan_id) }}" class=" btn btn-success text-end"  >Ubah Persetujuan</a>
                        @endif
                       
                      </tr>
                    
                      </td>
                    </tr>
                  @endforeach

                </tbody>
              </table>
            </div>
          </div>
            <!-- end show data -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection