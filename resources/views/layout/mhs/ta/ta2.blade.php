@extends('layout.mhs-main')
@section('title')

<title>Tugas Akhir</title>
{{-- revisi proposal --}}
@endsection
@section('content')
{{-- @if ($syarat !== 3)
<div class="content-wrapper">
  <section class="content">
    <div class="container">
      <h1>Silahkan isi syarat Tugas Akhir </h1>
    </div>
  </section>

</div>
@else --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Upload Tugas Akhir</h1>
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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                        <a data-toggle="modal" data-target="#modalInfo" class="btn btn-info">Lihat Status Tugas Akhir</a>
                      </div>
                 
                     
                      <div class="modal fade " id="modalInfo" tabindex="-1" aria-labelledby="modalInfo" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel">Status Tugas Akhir</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <label for="">Status Tugas Akhir</label>
                            <p>{{ $status->status }}</p>
                            <label for="">Daftar Revisi</label>
                            @foreach ($comment as $c)
                              <p>{{ $c->isi }}</p>
                              @endforeach
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                      <div class="form-group">
                        <a href="{{ route('mhs.editTA',['id'=>$id]) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> Update
                           Tugas Akhir</a>
                      </div>
                      @foreach ($proposal as $data)
                    <div class="form-group">
                        <label for="">NPM</label>
                        <input type="text" class="form-control" value="{{ $data->npm }}" readonly>
                    </div>
                    <div class="form-group">
                      <label for="">Nama</label>
                      <input type="text" class="form-control" value="{{ $data->name }}" readonly>
                  </div>
                      <div class="form-group">
                        <label for="">Judul</label>
                        <input type="text" class="form-control" value="{{ $data->judul }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for=""> Revisi</label>
                       <a href="{{ route('mhs.viewProposal',['id'=>$data->dokumen]) }}" class="form-control">{{ $data->dokumen }}</a>

                    </div>
                    <div class="form-group">
                      <label for="">Pembimbing</label>
                      <input type="text" class="form-control" value="{{ $data->domen }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="">Abstrak</label>
                      <textarea name="" class="form-control" id="" cols="10" rows="10" readonly>{{$data->deskripsi }}</textarea>
                    </div>
              
                    
                      @endforeach
                        
                    </div>
                </form>
              </div>
             </div>
            </form>
            {{-- end form --}}
        </div>
    </section>


    <!-- /.content -->
  

    <!-- /.content -->
  </div>
    </div>
  {{-- @endif --}}
@endsection
