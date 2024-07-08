@extends('layout.dsn-main')
@section('title')

<title>Proposal</title>
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
          {{-- form start --}}
            <form action="{{ route('dmn.store2') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">
                <form>
                    <div class="card-body">
                        <div class="form-group">
                              <a href="{{ route('dmn.viewTa',['id' => $proposal]) }}">
                                <img src="{{ asset('img/pdf.png') }}" style="width: 4%" alt="">
                              </a>
                            </div>

                        <div class="form-group">
                            <label for="">Komentar</label>
                            <textarea class="form-control" name="comment" placeholder="Enter Comment" ></textarea>
                            @error('komentar')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                          <h4>Apa laporan perlu direvisi ?</h4>
                        </div>
                        <div class="form-group text-center">
                          <input type="radio" name="status" value="Selesai">
                          <label for="">No</label>
                          &nbsp;
                          <input type="radio" name="status" value="Revisi">
                          <label for="">Yes</label>
                        </div>
                        <input type="text" name="laporan_id" value="{{ $id }}" hidden>
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
