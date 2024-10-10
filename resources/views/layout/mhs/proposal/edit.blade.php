@extends('layout.mhs-main')
@section('title')

<title>Edit Proposal</title>
{{-- revisi proposal --}}
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

    </div>
    <!-- /.content-header -->
 

    <!-- Main content -->
    <section class="content">
        <div class="container">
      
            {{-- form start --}}
            <form action="{{ route('mhs.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">
                    <div class="card-body">
                    

                      @foreach ($proposal as $data)
                    <div class="form-group">
                        <label for="">NPM</label>
                        <input type="text" class="form-control" value="{{ $data->npm }}" disabled>
                    </div>
                    <div class="form-group">
                      <label for="">Nama</label>
                      <input type="text" class="form-control" value="{{ $data->name }}" disabled>
                  </div>
                      <div class="form-group">
                        <label for="">Judul</label>
                        <input type="text" name="judul" class="form-control" value="{{ $data->judul }}" >
                    </div>

                    <div class="form-group">
                        <label for=""> Revisi</label>
                       <input type="file" name="revisi" class="form-control">
                       @error('revisi')
                       <div class="alert alert-danger">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="form-group">
                      <label for="">Pembimbing</label>
                      <input type="text" class="form-control" value="{{ $data->domen }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="">Abstrak</label>
                      <textarea name="abstrak" class="form-control" name="abstrak" cols="30" rows="10" >{{ $data->deskripsi }}</textarea>
                    </div> 
                    <input type="text" name="status" value="{{ $data->type }}" hidden >   
                      @endforeach
                        
                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                      </div>
                    </div>

                  </div>

                </div>

            </form>
            {{-- end form --}}
        </div>
    </section>


    <!-- /.content -->
  

    <!-- /.content -->
  </div>
    </div>
@endsection
