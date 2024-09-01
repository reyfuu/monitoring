@extends('layout.admin-main')
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

  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      {{-- <div class="row"> --}}

        <table class="table table-hover ">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Bimbingan</th>
              <th>Topik</th>
              <th>Status</th>

              
            </tr>
          </thead>
          <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->topik }}</td>
                <td>
                @if ($d->status == 'disetujui')
                  <i class="fa fa-check" style="color:#008d4c"></i></td>
                @else
                </td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
        </div>
    </div>
  </section>
</div>
@endsection