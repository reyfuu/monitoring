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
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Detail</th>
                  </tr>
                </thead>
                <tbody>
               
                  <tr>
                    <td>Audi Nathanael</td>
                    <td>audinathanael@gmail.com</td>
                    <td>Revisi Bab 3</td>
                    <td><a href="{{ route('admin.proposal2') }}"><button class="btn btn-primary">See Detail</button></a></td>
                </tr>
                <tr>
                  <td>sandhika</td>
                  <td>sandhika@gmail.com</td>
                  <td>laporan belum diperiksa</td>
                  <td><a href="{{ route('admin.proposal2') }}"><button class="btn btn-primary">See Detail</button></a></td>
              </tr>
              <tr>
                <td>Eka</td>
                <td>eka@gmail.com</td>
                <td>laporan sudah fix</td>
                <td><a href="{{ route('admin.proposal2') }}"><button class="btn btn-primary">See Detail</button></a></td>
            </tr>
            <tr>
              <td>Riza</td>
              <td>riza@gmail.com</td>
              <td>Revisi Penutup</td>
              <td><a href="{{ route('admin.proposal2') }}"><button class="btn btn-primary">See Detail</button></a></td>
          </tr>


               

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