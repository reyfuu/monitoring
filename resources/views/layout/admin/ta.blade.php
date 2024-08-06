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
          <h1 class="m-0">Dashboard Admin</h1>
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
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      {{-- <div class="row"> --}}
       <div class="row px-4 mt-4">
          <div class="col-md-6 row mb-3">
            <div class="col-2 col-form-label">
              Angkatan
            </div>
            <div class="col-10">
              <select name="angkatan" class="form-control">
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 row mb-3">
            <div class="col-2 col-form-label">
              Status
            </div>
            <div class="col-10">
              <select name="angkatan" class="form-control">
                <option value="Selesai">Selesai</option>
                <option value="Submit">Submit</option>
              </select>
            </div>
          </div>
      
       </div>

        <button class="btn btn-primary float-end">Cetak</button>


        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
              <th>Nama Mahasiswa</th>
              <th>Judul Tugas Akhir</th>
              <th>Nama pembimbing</th>
              <th>Tanggal Pengajuan</th>
              <th>Status</th>
              <th>Aksi</th>
              
            </tr>
          </thead>
          <tbody>

              @foreach ($data as $d)

              <tr>
              <td>{{ $d->mahasiswa }}</td>
              <td>{{ $d->judul }}</td>
              <td>{{ $d->domen }}</td>
              <td>{{ $d->mulai }}</td>
              <td>{{ $d->status }}</td>
              <td>
                <a data-toggle="modal" data-target="#detailModal" class="btn btn-primary"> Detail</a>
                <a data-toggle="modal" data-target="#modal-delete"  class="btn btn-danger" > <i class="fas fa-trash-alt"></i> Delete</a>
              </td>
       
            </tr>
            @endforeach
            
          </tbody>
      
        </table>
        

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <div class="modal fade " id="detailModal" tabindex="-1" aria-labelledby="detailModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eventModalLabel">Daftar Bimbingan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-hover">
          <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Dosen Pembimbing</th>
            <th>Topik</th>
            <th>Disetujui</th>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>2020-10-10</td>
              <td>Ryan Putrananda</td>
              <td>Sistem monitoring</td>
              <td>Disetujui</td>
            </tr>
          </tbody>
        </table>
    </div>
  </div>
  <!-- /.content -->
</div>
<script>
  
</script>
@endsection