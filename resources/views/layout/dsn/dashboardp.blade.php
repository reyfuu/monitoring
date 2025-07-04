@extends('layout.dsn-main')
@section('title')

<title>Dashboard Proposal</title>
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard Proposal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard Proposal</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-12">
          <div class="card"> 
            <div class="card-header">


             
          
            <!-- show data -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>File Upload</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @foreach ($data as $d)
                  <tr>
                      <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $d->mahasiswa }}</td>
                      <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $d->judul }}</td>
                      <td>
                        @if ($d->dokumen)
                        <a href="{{ route('dmn.viewTa',['id'=>$d->dokumen ]) }}">
                          <img src="{{ asset('img/pdf.png') }}" style="width: 25%">
                        </a>
                        @else
                            Belum submit 
                        @endif

                      </td>
                      <td>
      
                        @if ($d->status)
                            {{ $d->status }}
                        @else
                            belum dilihat
                        @endif

                      </td>
                      <td>
                        <a data-toggle="modal" data-target="#modalInfo{{ $d->npm }}" class="btn btn-info">Lihat Status Proposal</a>
                        
                        @if ($d->status == 'Finish' || $d->status == 'belum submit')
                            
                        @else
                        <br>
                        <a href="{{ route('dmn.setujup',$d->laporan_id) }}" class=" btn btn-success text-end" >Ubah Persetujuan</a>
                        @endif
                       
                      </tr>
                      
                      </td>
                    </tr>
                    <div class="modal fade " id="modalInfo{{ $d->npm }}" tabindex="-1" aria-labelledby="modalInfo" aria-hidden="true">
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
                          @foreach ($eval as $c)
                          @if ($c->npm ==  $d->npm )
                          <p>{{ $c->isi }}</p>
                          @endif
                        
                          @endforeach
  
                       
                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                  
                  
                </tbody>
              </table>
            </div>
          </div>
            <!-- end show data -->
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
@endsection