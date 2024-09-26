@extends('layout.dsn-main')
@section('title')

<title>Dashboard Proposal</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Proposal</h1>
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
            <!-- show data -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach ($data as $d)
                  <tr>
                      <td>{{ $d->mahasiswa }}</td>
                      <td>{{ $d->judul }}</td>

                      <td>
                       
                        <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal" >Rekap Komentar</a>
                      </tr>
                       
                      </td>
                    </tr>
                  @endforeach
                  <div class="modal fade" id="modal">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Rekap Komentar Proposal ?</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form >
                            @foreach ($bimbingan as $b)
                                {{ $b->isi }}
                            @endforeach
                      
                        
                       </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  
                </tbody>
              </table>
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