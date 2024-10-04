@extends('layout.dsn-main')
@section('title')

<title>Persetujuan</title>
{{-- edit dosen --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">ubah Persetujuan Proposal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">ubah Persetujuan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
<section class="content">
    <div class="container">

            
        
        <form action="{{ route('dmn.update3')}}" method="post">
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
                            <label for="">Komentar</label>
                            <textarea name="comment" class="form-control" cols="30" rows="10"></textarea>
                            <input type="text" name="status" value="Proposal" hidden>
                            @error('comment')
                            <div class="alert alert-danger">
                              <p>{{ $message }}</p>
                            </div>
    
                            @enderror
                            <input type="hidden" name="laporan_id" value="{{ $id }}">
           
                        </div>
                        <div class="text-center form-group">
                          <button type="submit" class="btn btn-primary text-center">Simpan</button>
                      </div>
                    </div>
                </div>
               </form>

                </div>
            </div>
            
    </div>
</section>