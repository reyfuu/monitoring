@extends('layout.mhs-main')
@section('title')

<title>Tugas Akhir</title>
{{-- finish tugas akhir --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tugas Akhir</h1>
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
                  <span class="base-timeline__summary-text">Proposal</span>
              </li>
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Revisi</span>
              </li>
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Selesai</span>
              </li>
          </ul>
      </div>
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container">
                <form action="{{ route('mhs.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="card card-primary">
                        <h3 class="text-center py-lg-5">Selamat Tugas Akhir sudah Selesai</h3>
                  </div>
                 </div>
                </form>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection
