@extends('layout.dsn-main')
@section('title')

<title>Edit</title>
{{-- edit dosen --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Bimbingan Tugas Akhir</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Bimbingan</li>
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
            <form action="{{ route('dmn.update4') }}" method="post">
                @csrf
                @method('put')
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                  @foreach ($data as $d)
                      
                  
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Topik</label>
                            <input type="text" class="form-control" name="topik" value="{{ $d->topik }}"  required>
                            @error('topik')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" cols="30" rows="10">{{ $d->isi }}</textarea>
                            @error('deskripsi')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label for="">Tanggal</label>
                          <input type="date" class="form-control" name="tanggal" 
                           value="{{ $d->tanggal }}" required>
                          @error('tanggal')
                            <small>{{$message}}</small>
                          @enderror
                        </div>
      
                        <input type="hidden" name="id" value="{{ $d->bimbingan }}">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
             @endforeach
            </form>
            {{-- form end --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection