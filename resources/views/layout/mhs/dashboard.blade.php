@extends('layout.mhs-main')
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
        {{-- @if($notifikasi == 'sudah acc')
        <div class="alert alert-success">Proposal sudah di acc</div>       
    @endif
    @if ($notifikasi2 == 'sudah acc')
      <div class="alert alert-success">Tugas Akhir sudah di acc</div>     
    @endif --}}

      
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $count }}</h3>
                <p>Jumlah Bimbingan yang diapprove</p>
            </div>
        </div>

 @foreach ($judul as $item)
        @if ($item->judul)
        <h3>Judul: {{ $item->judul }}</h3>
        @else
            
        @endif


 @endforeach<!-- Judul Proposal -->


        
      <!-- /.row (main row) -->

  </section>
  <!-- /.content -->
</div>
@endsection