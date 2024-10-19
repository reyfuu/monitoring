@php
if (Session::has('npm')) {
    return route('login'); 
}elseif(Session::has('admin')){
  return route('login');
}
@endphp
{{-- dosen template --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @yield('title')
  <style>
    table{
      table-layout: fixed;
      width: 100%;
      word-wrap: break-word;
    }
    td{
   
      width: 200px;
    }
  </style>
  <link rel="stylesheet" href="{{asset('css/dsn-app.css?v=1.0.1')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('lte/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('lte/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('lte/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('lte/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('lte/plugins/summernote/summernote-bs4.min.css')}}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->

    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item dropdown">
        <a href="" class="nav-link" data-toggle="dropdown">
          <i class="far fa-bell"></i>
          @if ($jumlah_notifikasi == 0)
          <span class="badge badge-danger navbar-badge"></span>
          @else
          <span class="badge badge-danger navbar-badge">{{ $jumlah_notifikasi }}</span>
          @endif
 
        </a>
        <div class="dropdown-menu dropdown-menu-lg">

              
          @if ($notifikasi_idd->isEmpty())
          <p class="dropdown-item">Notifikasi tidak ada</p>
          @else
          @foreach ($notifikasi_idd as $n)
          <a href="{{ route('dmn.markAsRead',['id'=> $n->notifikasi_id]) }}" ><p class="dropdown-item">{{ $n->message }}</p></a>
          @endforeach
          @endif

  
        </div>
      </li>
      <li class="nav-item dropdown">
        <a href="{{ route('dmn.chat') }}" class="nav-link chatbox-toggle"  >
            <i class="far fa-comment"></i>
        </a>
       
      </li>
  
 
     
      {{-- Logout & user --}}
      <li class="nav-item dropdown">
        <a href="" class="nav-link" data-toggle="dropdown">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg">
          <p class="dropdown-item disabled">Hello, 
            @php
                    echo session()->get('username');
            @endphp
          </p>
          <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>

  </nav>
  <!-- /.navbar -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dmn.dashboard') }}" class="brand-link">
      <img src="{{asset('img/logo.png')}}" alt="TAMP Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">TAMP</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- SidebarSearch Form -->
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item ">
            <a href="{{ route('dmn.dashboard') }}" class="nav-link">
             <img src="{{ asset('img/home.png') }}" style="width: 20%" alt="">
              <p class="mx-2">
                Dashboard
              </p>
            </a>
          </li>

           <li class="nav-item ">
            <a  class="nav-link">
              <img src="{{ asset('img/book-open.png')}}" style="width: 20%" alt="">
              <p class="mx-2">
                Proposal
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('dmn.proposal') }}" class="nav-link">
                 Proposal
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('dmn.dbimbingan') }}" class="nav-link">
                    Bimbingan
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item ">
            <a class="nav-link">
              <img src="{{ asset('img/clipboard.png') }}" style="width: 20%" alt="">
              <p class="mx-2">
                Tugas Akhir
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('dmn.ta') }}" class="nav-link">
                 Tugas Akhir
             
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('dmn.dbimbingan2') }}" class="nav-link">
        
                    Bimbingan

                </a>
              </li>
            </ul>
          </li>
    
        

    
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
@yield('content')
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="{{asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->  
<!-- Sparkline -->
<script src="{{asset('lte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('lte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('lte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('lte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('lte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('lte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('lte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('lte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="{{asset('lte/dist/js/demo.js')}}"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="{{asset('lte/dist/js/pages/dashboard.js')}}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@yield('script')

</body>
</html>
