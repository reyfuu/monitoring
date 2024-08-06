@extends('layout.mhs-main')
@section('title')

<title>Create</title>
{{-- create bimbingan --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Buat Akun</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Buat Akun</li>
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
            <form action="{{ route('mhs.store3') }}" method="post">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Topik</label>
                            <input type="text" class="form-control" name="topik" placeholder="Topik" required>
                            @error('topik')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <label for="">Dosen / Mentor</label>
                        <select class="form-control" name="dosen" aria-label="Default select example" required>
                          <option hidden disabled selected value>{{ $name }}</option>
                    
                                <option value="{{ $name }}">{{ $name }}</option>

                        </select>
                        @error('dosen')
                         <small>{{$message}}</small>
                        @enderror
                        <div class="form-group">
                            <label for="">Bahasan</label>
                            <textarea class="form-control" name="isi"  required></textarea>
                            @error('isi')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                          <label for="">Tanggal </label>
                          <input type="date" class="form-control" name="tanggal"  required>
                          @error('tanggal')
                            <small>{{$message}}</small>
                          @enderror
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
            {{-- end form --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection