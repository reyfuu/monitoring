@extends('layout.admin-main')
@section('title')

<title>Dashboard</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Dosen dan Mentor</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Dosen dan Mentor</li>
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
          {{-- button create --}}
          <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Buat Akun</a>
          <div class="card"> 
            <!-- display data -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>

                  {{-- display data dosen --}}
                  @foreach ($data as $d )
                  <tr>
                      <td>{{$loop->iteration}}</td>
                      <td style="white-space: pre-wrap;word-wrap: break-word;">{{$d->name}}</td>
                      <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{$d->email}}</td>
                      <td>{{$d->status}}</td>
                      <td>
                       
                          <a href="{{ route('admin.edit2',['id' =>$d->domen_id ]) }}" class="btn btn-primary" > <i class="fas fa-pen"></i> Edit</a>
                          <br><br>
                          <a data-toggle="modal" data-target="#modal-delete{{ $d->domen_id }}"  class="btn btn-danger" > <i class="fas fa-trash-alt"></i> Delete</a>
                      </td>
                      
                  </tr>
                  <div class="modal fade" id="modal-delete{{ $d->domen_id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Yakin Hapus data ?</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Apakah Anda yakin ingin menghapus <b>{{ $d->name }}</b> ?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <form action="{{ route('admin.delete2',['id'=>$d->domen_id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <div class="text-center">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Yes</button>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- /.modal-content -->
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
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection