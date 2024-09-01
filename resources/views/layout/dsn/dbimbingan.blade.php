@extends('layout.dsn-main')
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
          <h1 class="m-0">Dashboard</h1>
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

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{  $countMahasiswa}}</h3>
                <p>Total mahasiswa yang dibimbing</p>
            </div>
        </div>

        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $i }}</h3>
                <p>Total mahasiswa yang sudah validasi</p>
            </div>
        </div>
        
      <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
@endsection