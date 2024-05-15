@extends('layout.mhs-main')
@section('title')

<title>Laporan Bulanan</title>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Laporan Bulanan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Laporan Bulanan</li>
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
                      <h5 class="card-title">Laporan Mingguan Bulan Januari <a href="{{ route('mhs.laporan2') }}"><img src="{{asset('img/next.png')}}" class="mx-2"></a> </h5>
                     
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <p class="card-text"><img src="{{asset('img/alert-circle.png')}}" class="mx-2">Revisi Laporan Harian</p>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">Laporan Mingguan Bulan Februari <a href="{{ route('mhs.laporan2') }}"></a> <img src="{{asset('img/next.png')}}" class="mx-2"></h5>
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header">
                      <p class="card-text"><img src="{{asset('img/check.png')}}" class="mx-2">Disetujui Mentor</p>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">Laporan Mingguan Bulan Maret<a href=""><img src="{{asset('img/next.png')}}" class="mx-2"></a></h5>
                    </div>
                  </div>
            </div>
          </div>
        </div>
    </section>
</div>

</section>
@endsection