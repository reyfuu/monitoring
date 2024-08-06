@extends('layout.admin-main')
@section('title')

<title>Create</title>

@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">add User</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="text-center">
                <div class="row">
                  <div class="col">
                    <a href="{{ route('admin.create2') }}">
                      <button class="btn btn-light">
                        <img src="{{ asset('img/mahasiswa.png') }}" alt="">
                        </button></a>
                        <h3>Mahasiswa</h3>
                  </div>
                  <div class="col">
                    <a href="{{ route('admin.create3') }}">
                      <button class="btn btn-light">
                        <img src="{{ asset('img/Dosen.png') }}" style="width:70%">
                      </button></a>
                      <h3>Dosen / Mentor</h3>
                  </div>
                </div>
              </div>
             </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection