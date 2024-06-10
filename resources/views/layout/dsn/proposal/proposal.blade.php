@extends('layout.dsn-main')
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
      <div class="container">
          <ul class="base-timeline">
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Revisi</span>
              </li>
              <li class="base-timeline__item">
                  <span class="base-timeline__summary-text">Selesai</span>
              </li>
          </ul>
      </div>
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container">
            <form action="" method="get" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                    <div class="card-body">
                        <div class="form-group">
                              <img src="{{ asset('img/pdf.png') }}" style="width: 4%" alt="">
                          </div>

                        <div class="form-group">
                            <label for="">Komentar</label>
                            <textarea class="form-control" name="deskripsi" placeholder="Enter Deskripsi" ></textarea>
                            @error('komentar')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                          <a href="{{ route('dmn.proposal3')  }}"> <button type="button" class="btn btn-primary">Submit</button></a> 
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection
