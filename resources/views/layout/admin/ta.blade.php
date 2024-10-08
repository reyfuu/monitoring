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
          <h1 class="m-0">Dashboard Tugas Akhir</h1>
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
              <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $d->judul }}</td>
              <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $d->domen }}</td>
              <td>{{ $d->mulai }}</td>
              <td>{{ $d->status_domen }}</td>
              <td>
                <a href="{{ route('admin.bimbingan2',['id'=>$d->npm]) }}" class="btn btn-primary"> Detail</a>
               
              </td>
       
            </tr>
            @endforeach
            
          </tbody>
      
        </table>
        

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>

  <!-- /.content -->
</div>
<script>
  
</script>
@endsection