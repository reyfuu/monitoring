<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('css/dsn-app.css')}}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css')}}">


</head>
<body class="hold-transition login-page " id="background">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary py-3">
    <div class="card-header text-center  ">
      <a href="{{ route('login') }}'}}" class="h1"><b>TAMP</b></a>
      <img src="{{asset('img/logo_IF.png')}}" class="" style="width: 30%; margin-bottom:20px" alt="">
      <p class="text-center"> <b>T</b>hesis <b>A</b>nd <b>M</b>onitoring <b>P</b>latform</p>
    </div>
    <div class="text-right">
   
    </div>

    <div class="card-body">

      <form action="{{ route('login-proses') }}" method="post">
        @csrf
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
          @error('email')
            <small>{{ $message }}</small>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
            <small>{{ $message }}</small>
          @enderror
        </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->

          <!-- /.col -->
        </div>
        <p class="text-center"> Version 1.0</p>
      </form>

      <!-- /.social-auth-links -->

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('lte/dist/js/adminlte.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if ($message= Session::get('success'))
  <script>
    Swal.fire('{{ $message }}')
  </script>
@endif
@if ($message= Session::get('failed'))
  <script>
    Swal.fire('{{ $message }}')
  </script>
@endif
</body>
</html>
