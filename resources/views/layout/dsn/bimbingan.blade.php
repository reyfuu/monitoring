@extends('layout.dsn-main')
@section('title')

<title>Dashboard Bimbingan</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Dosen</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      {{-- <div class="row"> --}}



        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Judul</th>
              <th>Status</th>
              <th>AKsi</th>     
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->topik }}</td>
                <td>
                @if ($d->status == 'disetujui')
                  <i class="fa fa-check" style="color:#008d4c"></i></td>
                @else
            
                @endif
                </td>
                <td>
                    <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal{{ $d->bimbingan_id }}" >Ubah Persetujuan</a>
                  </tr>
                    <div class="modal fade" id="modal{{  $d->bimbingan_id }}">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modIal-title">Apakah Syarat Valid ?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="{{ route('dmn.update2') }}" method="post">
                            @csrf
                            @method('put')
                              <input type="text" name="id_bimbingan" value={{ $d->bimbingan_id }} hidden >
                              <select name="status"  class="form-control">
                                  <option value="disetujui">disetujui</option>
                                  <option value="ditolak">ditolak</option>
                              </select>
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
             
            @endforeach
          </tbody>
        </table>
        </div>
    </div>
  </section>
</div>
@endsection