@extends('layout.mhs-main-magang')
@section('title')
    <title>Dashboard Mahasiswa magang</title>
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

  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $count }}</h3>
                <p>Jumlah Laporan Mingguan yang diapprove</p>
            </div>
        </div>
        
        
      <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
@endsection