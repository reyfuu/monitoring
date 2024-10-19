@extends('layout.dsn-main')
@section('title')

<title>Dashboard Bimbingan Proposal</title>

@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Bimbingan Proposal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Bimbingan Proposal</li>
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


      
 
            <!-- show data-->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($bimbingan as $data)


                  <tr>
                  <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $data->nama }}</td>
                  <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $data->topik }}</td>
                  <td>{{ $data->status2 }}</td>
        
          
                  <td><a href="{{ route('dmn.bimbingan',['id'=>$data->npm]) }}" class="btn btn-primary" name="submit">Lihat Detail</a></td>
     
                  </tr>
                 
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
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection