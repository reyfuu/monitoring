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
          <h1 class="m-0">Daftar Bimbingan Proposal</h1>
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
              <th>Topik</th>
              <th>Deskripsi</th>
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
                <td>{{ $d->isi }}</td>
                <td>
                @if ($d->status )
                  {{ $d->status }}
                @else
                
                @endif
                </td>
                <td>
                    <a href="{{ route('dmn.detailb', $d->bimbingan_id) }}" class="btn btn-primary text-end">Detail</a>
                    @if ($d->status == 'disetujui')
                        
                    @else
                    <a href="{{ route('dmn.setujubp',['id'=>$d->bimbingan_id]) }}" class=" btn btn-success text-end"  >Ubah Persetujuan</a>
                    @endif
                    
                  </tr>
                  
           
                </td>
             
            @endforeach
            
            
  </section>
</div>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($message= Session::get('success'))
  <script>
    Swal.fire('{{ $message }}')
  </script>
@endif
@if ($message= Session::get('failed'))
  <script>
    Swal.fire('{{ $message }}')
  </script>
@endif
@endsection