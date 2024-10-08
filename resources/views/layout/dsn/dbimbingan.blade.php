@extends('layout.dsn-main')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{  $countMahasiswa}}</h3>
                <p>Total mahasiswa yang dibimbing</p>
            </div>
        </div>
        @if (empty($mentor))
        <div class="small-box bg-primary">
          <div class="inner">
              <h3>{{ $dt_mahasiswa }}</h3>
              <p>Total mahasiswa yang sudah validasi</p>
          </div>
      </div>
        @endif

      <!-- /.row (main row) -->

      <div class="container">
        <div class="row ">
          <div class="chartBox">
            <h3 class="text-center">Proposal</h3>
            <canvas id="myChart" width="400" height="400" style="padding: 50px"></canvas>
          </div>
          <div class="chartBox">
            <h3 class="text-center">Tugas Akhir</h3>
            <canvas id="tugasAkhir" width="400" height="400" style="padding: 50px"></canvas>
          </div>
      </div>    


  </section>
  <!-- /.content -->
</div>
@section('script')
<script>
  const ctx = document.getElementById('myChart');
  const ctx2 = document.getElementById('tugasAkhir');


  new Chart(ctx2, {
    type: 'pie',
    data: {
      labels:@json($tugasAkhir->map(fn ($tugasAkhir) => $tugasAkhir->status)),
      datasets: [{
        label:'jumlah mahasiswa',
        data: @json($tugasAkhir->map(fn ($tugasAkhir) => $tugasAkhir->count)),

        hoverOffset:4
      }]

    },
    options: {
      plugins: {
        legend: {
            display: false // Sembunyikan legenda
        },
        datalabels: {
            display: false // Sembunyikan label pada potongan pie
        }
    },
    scales: {
        xAxes: [{
            ticks: {
                display: false
            }
        }],
        yAxes: [{
            ticks: {
                display: false
            }
        }]
    }
}
    
  });
  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: @json($coba->map(fn ($coba) => $coba->status)),
      datasets: [{
        label: 'Jumlah dari mahasiswa',
        data: @json($coba->map(fn ($coba) => $coba->count)),

        hoverOffset:4
      }]
    },
    options: {
      plugins: {
        legend: {
            display: false // Sembunyikan legenda
        },
        datalabels: {
            display: false // Sembunyikan label pada potongan pie
        }
    },
    scales: {
        xAxes: [{
            ticks: {
                display: false
            }
        }],
        yAxes: [{
            ticks: {
                display: false
            }
        }]
    }
}
  });

</script>
@endsection
@endsection
