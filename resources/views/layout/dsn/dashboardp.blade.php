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
                    <th>File Upload</th>
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
                        <a href="{{ route('dmn.viewTa',['id'=>$d->dokumen ?? 'BELUM SUBMIT.pdf']) }}">
                          <img src="{{ asset('img/pdf.png') }}" style="width: 25%" alt="">
                        </a>
                      </td>
                      <td>
      
                        @if ($d->status_domen)
                            {{ $d->status_domen }}
                        @else
                            belum dilihat
                        @endif

                      </td>
                      <td>
                        <a href="{{ route('dmn.rekapp',$d->npm) }}" class="btn btn-primary text-end" >Detail</a>
                        <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal{{ $d->laporan_id }}" >Ubah Persetujuan</a>
                      </tr>
                        <div class="modal fade" id="modal{{ $d->laporan_id }}">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Apakah Proposal Valid ?</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                              <form action="{{ route('dmn.update3')}}" method="post">
                                @csrf
                                @method('put')
                                  <input type="text" name="laporan_id" value={{ $d->laporan_id }} hidden>
                                  <label for="">Status</label>
                                  <select name="status_domen"  class="form-control">
                                      <option value="disetujui">disetujui</option>
                                      <option value="direvisi">direvisi</option>
                                  </select>
                                  <label for="">Komentar</label>
                                  <textarea name="comment" class="form-control" cols="30" rows="10"></textarea>
                                  <input type="text" name="status" value="Proposal" hidden>
                                  @error('comment')
                                    <small>{{ $message }}</small>
                                  @enderror
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
                      </td>
                    </tr>
                  @endforeach

                  
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