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

      <div class="container">
          <ul class="base-timeline">
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Proposal</span>
              </li>
              <li class="base-timeline__item base-timeline__item">
                  <span class="base-timeline__summary-text">Revisi</span>
              </li>
              <li class="base-timeline__item">
                  <span class="base-timeline__summary-text">Selesai</span>
              </li>
          </ul>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            {{-- form start --}}

                <div class="col-md-12">
                    <div class="card card-primary">
                      @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                  @elseif(session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif
    
                <form action="{{ route('mhs.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" name="judul" placeholder="Enter Judul" >
                            @error('judul')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Abstrak</label>
                            <textarea class="form-control" name="deskripsi" placeholder="Enter Deskripsi" ></textarea>
                            @error('deskripsi')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Dokumen</label>
                            <input type="file" class="form-control-file" name="file">
                            @error('file')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden"  name="status" value="Proposal">
                        <div class=" text-center ">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            {{-- end form --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection
