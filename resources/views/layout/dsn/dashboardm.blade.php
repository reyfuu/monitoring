@extends('layout.dsn-main-revisi')
@section('title')
    <title>Dashboard Mentor</title>
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


      <!-- /.row (main row) -->

        <div class="container" style="width: 400px">

            <div class="chartbox">
              <h3 class="text-center">Laporan Mingguan</h3>
              <canvas id="LaporanMingguan" width="100" height="100" ></canvas>
            </div>

        </div>
  </section>
  <!-- /.content -->
</div>
@section('script')
<script>

  const ctx3 = document.getElementById('LaporanMingguan');

  new Chart(ctx3, {
    type: 'pie',
    data: {
      labels:@json($LaporanMingguan->map(fn ($LaporanMingguan) => $LaporanMingguan->status)),
      datasets: [{
        label:'jumlah mahasiswa',
        data: @json($LaporanMingguan->map(fn ($LaporanMingguan) => $LaporanMingguan->count)),

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
