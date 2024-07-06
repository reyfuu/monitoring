@extends('layout.dsn-main')
@section('title')

<title>Dashboard Laporan</title>

@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Laporan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
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


              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="submit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- show data-->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($combinedData as $data)
                    @foreach ($data as $dataWeek)
                        
       
                  @if ($dataWeek['has_laporan'])
                  <tr>
                  <td>{{ $dataWeek['name']}}</td>
                  <td>{{ $dataWeek['email'] }}</td>
                  <td>{{ $dataWeek['isi'] }}</td>
                  <td><a href="{{ route('dmn.laporan2') }}"><button class="btn btn-primary">Lihat Detail</button></a></td>
                  </tr>
                  @else
                  <tr ><td colspan='4'class="text-center">Tidak ada mahasiswa</td></tr>
                  @endif
                  @endforeach
                  @endforeach

                
                </tbody>
              </table>
              {{-- end show data --}}
            </div>
            <!-- /.card-body -->
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