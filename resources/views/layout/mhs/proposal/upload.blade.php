@extends('layout.mhs-main')
@section('title')
<title>Upload Dokumen</title>
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
<div class="section-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                <form action="{{ route('mhs.store') }}" method="post">
                    <div class="form-group">
                        <label for="">Dokumen</label>
                        <input type="file" class="form-control-file" name="file" required>
                        @error('file')
                            <small>{{$message}}</small>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
</div>
@endsection