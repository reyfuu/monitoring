@extends('layout.mhs-main')
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
            
   
                  @if (isset($weekends) && count($weekends) > 0)

                      @foreach ($weekends as $weekend)
                      <div class="card">
                        <div class="card-header">
                          <p class="card-text"><img src="{{asset('img/wait.png')}}" class="mx-2">Menunggu Persetujuan Mentor</p>
                        </div>
                        <div class="card-body">
                      <h5 class="card-title">{{ $weekend['start_date'] }}
                        @if ($weekend['start_month'] != $weekend['end_month'])
                            {{ $weekend['start_month'] }}
                      @endif-{{ $weekend['end_date'] }} 
                      @if ($weekend['start_month'] == $weekend['end_month'])
                          {{ $weekend['start_month'] }}
                      @else
                          {{ $weekend['end_month'] }}
                      @endif
                       <a href="{{ route('mhs.laporan3') }}"><img src="{{asset('img/next.png')}}" class="mx-2"></a></h5>
                      <p class="card-text">Minggu ke {{ $loop->iteration }}</p>
                      
                  </div>
                </div>
                      @endforeach
                @else
                  <p>No captured weekend data found.</p>
                @endif
                

    
          </div>
        </div>
    </section>
</div>

</section>
@endsection