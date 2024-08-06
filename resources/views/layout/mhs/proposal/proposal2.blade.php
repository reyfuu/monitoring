@extends('layout.mhs-main')
@section('title')

<title>Proposal</title>
{{-- revisi proposal --}}
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Upload Proposal</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Proposal</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="container">
          <ul class="base-timeline">
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Proposal</span>
              </li>
              <li class="base-timeline__item base-timeline__item--active">
                  <span class="base-timeline__summary-text">Revisi</span>
              </li>
              <li class="base-timeline__item">
                  <span class="base-timeline__summary-text">Selesai</span>
              </li>
          </ul>
      </div>
    </div>
    <!-- /.content-header -->
 

    <!-- Main content -->
    <section class="content">
        <div class="container">
            {{-- form start --}}
            <form action="{{ route('mhs.update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="card card-primary">


                <form>
                    <div class="card-body">

                      <div class="form-group">
                        <a data-toggle="modal" data-target="#modalInfo" class="btn btn-info">Lihat Status Proposal</a>
                      </div>
 
                        <div class="form-group">
                            <label for="">Judul</label>
                            <input type="text" class="form-control" value="{{ $judul }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="">Upload Revisi</label>
                            <input type="file" class="form-control-file" name="file" required>
                            @error('file')
                                <small>{{$message}}</small>
                            @enderror
                        </div>

                        <input type="hidden"  name="status" value="Proposal">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
              </div>
             </div>
            </form>
            {{-- end form --}}
        </div>
    </section>


    <!-- /.content -->
    @foreach ($comment as $c)
        

    <div class="modal fade " id="modalInfo" tabindex="-1" aria-labelledby="modalRevisi" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="eventModalLabel">Status Proposal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label for="">Status Proposal</label>
          <p>{{ $status }}</p>
          <label for="">Daftar Revisi</label>
            <p>{{ $c->isi }}</p>
          </table>
      </div>
    </div>
    @endforeach
    <!-- /.content -->
  </div>
    </div>
@endsection
