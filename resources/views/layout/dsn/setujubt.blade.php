@extends('layout.dsn-main')
@section('title')

<title>Persetujuan Bimbingan Proposal</title>
{{-- edit dosen --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Persetujuan Bimbingan Tugas Akhir</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Persetujuan Bimbingan Tugas Akhir</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<section class="content">
    <div class="container">
        @foreach ($data as $d)
            
        
        <form action="{{ route('dmn.update2')}}" method="post">
            @csrf
            @method('put')
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="form-group">
                            
                            
                          <label for="">Status</label>
                          <select name="status_domen"  class="form-control">
                              <option value="disetujui">disetujui</option>
                              <option value="direvisi">direvisi</option>
                          </select>
                        
                            <input type="text" name="id" value="{{ $id }}" hidden>
 
                        </div>
                        <div class="form-group">
                          <label for="">Komentar</label>
                          <textarea name="eval" class="form-control" cols="30" rows="10"></textarea>
                          <input type="text" name="status" value="Tugas Akhir" hidden>
                          @error('eval')
                            <div class="alert alert-danger">
                              <p>{{ $message }}</p>
                            </div>
                          @enderror
                      </div>
                        <div class="form-group">
                          <div class="text-center">
                            <button type="submit" class="btn btn-primary text-center">Simpan</button>
                        </div>
                        </div>
                    </div>
                </div>
               </form>
               @endforeach
                </div>
            </div>
            
    </div>
</section>
@endsection