@extends('layout.mhs-main')
@section('title')

<title>Proposal</title>
@endsection
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Upload Proposal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Proposal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container">
            {{-- form start --}}
            <form action="{{ route('mhs.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">

                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Enter Judul" required>
                            @error('judul')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" placeholder="Enter Deskripsi" required></textarea>
                            @error('deskripsi')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Dokumen</label>
                            <input type="file" class="form-control-file" name="file" required>
                            @error('file')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <input type="hidden"  name="status" value="Proposal">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
