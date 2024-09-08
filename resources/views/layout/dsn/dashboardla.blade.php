@extends('layout.dsn-main-revisi')
@section('title')

<title>Dashboard </title>

@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Laporan Mingguan</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
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
                    <th>isi</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($mahasiswa as $data)

                  <tr>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->isi }}</td>
                  <td>{{ $data->status }}</td>
                 
                    <td>  <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal{{ $data->id }}" >Ubah Persetujuan</a></td>
                  </tr>
               
                  <div class="modal fade" id="modal{{ $data->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Apakah Syarat Valid ?</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                        <form action="{{ route('dmn.update4')}}" method="post">
                          @csrf
                          @method('put')
                            <input type="text" name="laporan_id" value={{ $data->id }} hidden>
                            <label for="">Status</label>
                            <select name="status_domen"  class="form-control">
                                <option value="disetujui">disetujui</option>
                                <option value="direvisi">direvisi</option>
                                <option value="ditolak">ditolak</option>
                            </select>
                            <label for="">Komentar</label>
                            <textarea name="comment" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">

                            <div class="text-center">
                              <button type="submit" class="btn btn-primary text-center">Yes</button>
                            </div>
                        </div>
                       </form>
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