@extends('layout.mhs-main')
@section('title')

<title>Dashboard</title>
{{-- dashboard bimbingan  --}}
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bimbingan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Bimbingan </li>
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
          {{-- button create bimbingan --}}
          <a href="{{ route('mhs.create') }}" class="btn btn-primary mb-3">Buat laporan bimbingan</a>
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
      
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Dosen</th>   
                  </tr>
                </thead>
                <tbody>
                  <!-- show data -->
                  @foreach ($bimbingan as $d )
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$d->tanggal}}</td>
                      <td>{{$name}}</td>
     
                      <td>
                          <a href="{{ route('mhs.edit',['id' =>$d->npm ]) }}" class="btn btn-primary" > <i class="fas fa-pen"></i> Edit</a>
                          <a data-toggle="modal" data-target="#modal-delete{{ $d->bimbingan_id }}" href="{{ route('mhs.delete',['id' => $d->bimbingan_id ]) }}" class="btn btn-danger" > <i class="fas fa-trash"></i> Hapus</a>
                      </td>   
                  </tr>
                  <!-- end show data -->
              </div>
              <div class="modal fade" id="modal-delete{{ $d->bimbingan_id }}">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Yakin Hapus data ?</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>Apakah Anda yakin ingin menghapus ?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <form action="{{ route('mhs.delete',['id'=>$d->bimbingan_id]) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                      </form>
                    </div>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
              </div>
                    <!-- /.modal-dialog -->
            </div>
                  @endforeach
            
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row (main row) -->
  </section>
@endsection