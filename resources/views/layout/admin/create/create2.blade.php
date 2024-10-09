@extends('layout.admin-main')
@section('title')

<title>Create</title>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buat Akun Mahasiswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Buat Akun Mahasiswa</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container">
          {{-- form start --}}
            <form action="{{ route('admin.store') }}" method="post">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">NPM </label>
                        <input type="number" class="form-control" name="npm" placeholder="NPM" >
                        @error('npm')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="Nama" >
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" >
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" >
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <label for="">Status</label>
                        <select class="form-control" name="status" aria-label="Default select example" >
                          <option hidden disabled selected value>Pilih Opsi</option>
                          <option value="Magang">Magang</option>
                          <option value="Tugas Akhir">Tugas Akhir</option>
                          <option value="Magang dan Tugas Akhir">Magang dan Tugas Akhir</option>
                        </select>
                        @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <label for="">Dosen / Mentor</label>
                        <select class="form-control" name="dosen" aria-label="Default select example" >
                          <option hidden disabled selected value>Pilih Opsi</option>
                            @foreach ($data as $d)
                                <option value="{{ $d->name }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                        @error('dosen')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group">
                          <label for="">Tanggal Mulai</label>
                          <input type="date" class="form-control" name="tanggal_mulai"  >
                          @error('tanggal_mulai')
                          <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label>Angkatan</label>
                          <input class="form-control" name="angkatan" placeholder="Enter Angkatan" >
                        </div>
                        @error('angkatan')
                       
                      @enderror
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
            {{-- form end --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection