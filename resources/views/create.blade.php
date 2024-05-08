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
        <div class="container">
            <form action="{{ route('admin.store') }}" method="post">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                            @error('name')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Email" required>
                            @error('email')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                            @error('password')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <label for="">Status</label>
                        <select class="form-control" name="status" aria-label="Default select example">
                          <option value="Magang">Magang</option>
                          <option value="Tugas Akhir">Tugas Akhir</option>
                          <option value="Magang dan Tugas Akhir">Magang dan Tugas Akhir</option>
                          <option value="Dosen">Dosen</option>
                          <option value="Mentor">Mentor</option>
                        </select>
                        @error('status')
                         <small>{{$message}}</small>
                        @enderror
                        <div class="form-group">
                          <label for="">Start</label>
                          <input type="date" class="form-control" name="tanggal_mulai"  required>
                          @error('date')
                            <small>{{$message}}</small>
                          @enderror
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection