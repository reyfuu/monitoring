@extends('layout.dsn-main')
@section('title')

<title>Laporan Mingguan</title>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Laporan Mingguan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Laporan Mingguan</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <section class="content">
        <div class="container">
          <div class="col-md-12">
            <div class="card card-primary">
                <div class="card">
                    <div class="card-header">
                      <p class="card-text"><img src="{{asset('img/wait.png')}}" class="mx-2">Menunggu Persetujuan Mentor</p>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">4-9 Maret 2024 <a href="{{ route('mhs.laporan3') }}"><img src="{{asset('img/next.png')}}" class="mx-2"></a></h5>
                      <p class="card-text">Minggu ke 1</p>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <p class="card-text"><img src="{{asset('img/alert-circle.png')}}" class="mx-2">Revisi Laporan Harian</p>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">12-16 Maret 2024 <a href="{{ route('dmn.laporan') }}"><img src="{{asset('img/next.png')}}" class="mx-2"></a></h5>
                      <p class="card-text">Minggu ke 2</p>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <p class="card-text"><img src="{{asset('img/check.png')}}" class="mx-2">Disetujui Mentor</p>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">18-23 Maret 2024 <a href="{{ route('mhs.laporan3') }}"><img src="{{asset('img/next.png')}}" class="mx-2"></a></h5>
                      <p class="card-text">Minggu ke 3</p>
                    </div>
                  </div>
            </div>
          </div>
        </div>
    </section>
</div>

</section>
@endsection