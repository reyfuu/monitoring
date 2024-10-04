@extends('layout.admin-main')
@section('title')

<title>Edit</title>
{{-- edit mahasiswa --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Akun</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Akun</li>
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
            <form action="{{ route('admin.update',['id'=> $id2->npm]) }}" method="post">
                @csrf
                @method('put')
                <div class="col-md-12">
                    <div class="card card-primary">
             

                <form>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">NPM</label>
                        <input type="text" class="form-control" name="npm" value="{{ $id2->npm }}"  required>
                        @error('npm')
                            <small>{{$message}}</small>
                        @enderror
                    </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" name="name" value="{{ $id2->name }}"  required>
                            @error('name')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ $id2->email }}"  required>
                            @error('email')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password" >
                            @error('password')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <label for="">Status</label>
                        <select class="form-control" name="status" wire:model="selectedClass" aria-label="Default select example" required>
                          <option hidden disabled selected value>Pilih Opsi</option>
                          <option value="Magang">Magang</option>
                          <option value="Tugas Akhir">Tugas Akhir</option>
                          <option value="Magang dan Tugas Akhir">Magang dan Tugas Akhir</option>
                        </select>
                        @error('status')
                         <small>{{$message}}</small>
                         @enderror
                        <div class="form-group">
                          <label for="">Start</label>
                          <input type="date" class="form-control" name="tanggal_mulai" 
                           value="{{ $tanggal_mulai }}" required>
                          @error('tanggal_mulai')
                            <small>{{$message}}</small>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="">End</label>
                          <input type="date" class="form-control" name="tanggal_berakhir" 
                           value="{{ $tanggal_berakhir }}" required>
                          @error('tanggal_berakhir')
                            <small>{{$message}}</small>
                          @enderror
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" wire:Loading.attr="disabled">Simpan</button>
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