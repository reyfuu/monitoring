@extends('layout.mhs-main')
@section('title')

<title>Tugas Akhir</title>
@endsection
@section('content')
@if (!$proposal || $proposal->status !== 'Finish')

      <h3 class=" text2">Selesaikan Proposal Terlebih dahulu</h3>

 
</div>

@else
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Upload Tugas Akhir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Tugas Akhir</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    <div class="container">
        <ul class="base-timeline">
            <li class="base-timeline__item base-timeline__item--active">
                <span class="base-timeline__summary-text">Tugas Akhir</span>
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
  <!-- /.content-header -->


  <!-- Main content -->
  <section class="content">
      <div class="container">
          @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
        @endif    
          {{-- start form --}}
          <form action="{{ route('mhs.store6') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="col-md-12">
                  <div class="card card-primary">
              <form>
                  <div class="card-body">
                      <div class="form-group">
                          <label for="">Judul</label>
                          <input type="text" class="form-control" name="judul" placeholder="Enter Judul">
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
                          <input type="file" class="form-control-file" name="file" >
                          @error('file')
                          <div class="alert alert-danger">{{ $message }}</div>
                          @enderror
                      </div>
                      <input type="hidden"  name="status" value="Laporan">
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
@endif


@endsection
