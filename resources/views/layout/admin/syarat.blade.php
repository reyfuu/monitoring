@extends('layout.admin-main')
@section('title')

<title>Syarat</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Admin zSyarat</h1>
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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Judul TA</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($mahasiswa as $m)
                <tr>
                  
                        <td>{{ $m->name }}</td>
                        <td>{{ $m->judul }}</td>
                        <td>{{ $m->status }}</td>
                    <td>
                      <a href="{{ route('admin.syarat2', ['id'=>$m->npm]) }}" class="btn btn-primary">Detail</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            
        </table>
    </div>
</section>
</div>
@endsection