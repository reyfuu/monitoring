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

                     
                      <div class="modal fade " id="modalInfo" tabindex="-1" aria-labelledby="modalInfo" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="eventModalLabel">Status Proposal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <label for="">Daftar Revisi</label>
                            @foreach ($komment as $c)
                         
                            <p>{{ $c->isi }}</p>
                            @endforeach

                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    @foreach ($data as $d)
                      <div class="form-group">
                        <a href="{{ route('mhs.editProposal',['id'=>$d->laporan_id]) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> Update Proposal</a>
                      </div>
                 
                    <div class="form-group">
                        <label for="">NPM</label>
                        <input type="text" class="form-control" value="{{ $d->npm }}" readonly>
                    </div>
                    <div class="form-group">
                      <label for="">Nama</label>
                      <input type="text" class="form-control" value="{{ $d->name }}" readonly>
                  </div>
                      <div class="form-group">
                        <label for="">Judul</label>
                        <input type="text" class="form-control" value="{{ $d->judul }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for=""> Revisi</label>
                       <a href="{{ route('mhs.viewProposal',['id'=> $d->dokumen]) }}" class="form-control">{{ $d->dokumen }}</a>

                    </div>
                    <div class="form-group">
                      <label for="">Pembimbing</label>
                      <input type="text" class="form-control" value="{{ $d->domen }}" readonly>
                    </div>

                    <div class="form-group">
                      <label for="">Abstrak</label>
                      <textarea name="" class="form-control" id="" cols="30" rows="10" readonly>
                        {{ $d->deskripsi }}
                      </textarea>
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
@endsection
