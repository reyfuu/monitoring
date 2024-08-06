@extends('layout.dsn-main')
@section('title')

<title>Dashboard Bimibingan</title>

@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Bimbingan</h1>
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
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach ($bimbingan as $data)


                  <tr>
                  <td>{{ $data->nama }}</td>
                  <td>{{ $data->topik }}</td>
                  <td>{{ $data->status2 }}</td>
                    <input type="text" name="week" value="{{ $data['week'] }}" hidden>
                    <input type="text" name="npm" value="{{ $data['npm'] }}" hidden>
                  <td><a ><button data-toggle="modal" data-target="#detailModal{{ $data->id }}" class="btn btn-primary" name="submit">Lihat Detail</button></a></td>
     
                  </tr>
                  <div class="modal fade " id="detailModal{{ $data->id }}" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Daftar Bimbingan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <p>{{ $data->isi }}</p>
                    </div>
                    <form action="{{ route('dmn.update2') }}" method="post">
                      @csrf
                    <div class="form-group text-center">
                      <h4>Apa laporan perlu direvisi ?</h4>
                    </div>
                    <div class="form-group text-center">
                      <input type="radio" name="status" value="Selesai">
                      <label for="">No</label>
                      &nbsp;
                      <input type="radio" name="status" value="Revisi">
                      <label for="">Yes</label>
                    </div>
                    <input type="text" name="laporan_id" value="{{ $data->id }}" hidden>
                    <div class="form-group text-center">
                       <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                    </form>
                  </div>

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