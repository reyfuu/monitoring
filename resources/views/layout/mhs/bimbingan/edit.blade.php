@extends('layout.mhs-main')
@section('title')

<title>Edit</title>
{{-- edit bimbingan --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Edit Bimbingan</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Bimbingan</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
          {{-- form start --}}
            <form action="{{ route('mhs.update2',['id'=> $data->bimbingan_id]) }}" method="post">
                @csrf
                @method('put')
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">Topik</label>
                        <input type="text" class="form-control" name="topik" value="{{ $data->topik }}"  required>
                        @error('topik')
                            <small>{{$message}}</small>
                        @enderror
                    </div>

                        <div class="form-group">
                            <label for="">Bahasan</label>
                            <textarea  class="form-control" name="isi"  required>{{ $data->isi }}</textarea>
                            @error('isi')
                                <small>{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                          <label for="">Tanggal </label>
                          <input type="date" class="form-control" name="tanggal" 
                            value="{{ $data->tanggal }}" required>
                          @error('tanggal')
                            <small>{{$message}}</small>
                          @enderror
                        
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" wire:Loading.attr="disabled">Simpan</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
            {{-- end form  --}}
        </div>
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->

@endsection