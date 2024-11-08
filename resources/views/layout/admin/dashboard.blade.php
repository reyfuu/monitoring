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
          <h1 class="m-0">Dashboard Proposal </h1>
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
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th style="      white-space: pre-wrap;
      word-wrap: break-word;">Nama Mahasiswa</th>
                      <th style="      white-space: pre-wrap;
      word-wrap: break-word;">Judul Proposal</th>
                      <th style="      white-space: pre-wrap;
      word-wrap: break-word;">Nama pembimbing</th>
                      <th>Status</th>
                      <th>Aksi</th>
                      
                    </tr>
                  </thead>
                  <tbody>
        
                      @foreach ($data as $d)
        
                      <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td style="      white-space: pre-wrap;
              word-wrap: break-word;">{{ $d->mahasiswa }}</td>
                      <td style="      white-space: pre-wrap;
              word-wrap: break-word;">{{ $d->judul }}</td>
                      <td style="      white-space: pre-wrap;
              word-wrap: break-word;">{{ $d->domen }}</td>
                      <td>{{ $d->status_domen }}</td>
                      <td style="      white-space: pre-wrap;
                      word-wrap: break-word;"><a href="{{ route('admin.bimbingan',['id'=>$d->npm]) }}" class="btn btn-primary"> Detail</a></td>
               
                    </tr>
                    @endforeach
                    
                  </tbody>
              
                </table>
              </div>
            </div>
          </div>
        </div>

        

      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
 
@endsection